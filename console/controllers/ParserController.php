<?php

namespace console\controllers;

use common\models\AutoBrands;
use common\models\AutoGenerations;
use common\models\AutoModels;
use common\models\CatalogCategories;
use common\models\Makers;
use common\models\Products;
use common\models\ProductsAutoVia;
use common\models\ProductsOriginalNumbers;
use GuzzleHttp\Client;
use yii\console\Controller;
use yii\helpers\Console;
use yii\helpers\Html;
use yii\helpers\Inflector;

class ParserController extends Controller
{
    /**
     * @var $client Client
     */
    public static $client;

    private $catalogId = 1;
    private $catalogCategoryId = 1;

    private $autoPages = [
        '/zapchasti/na-audi',
        '/zapchasti/na-vw',
        '/zapchasti/na-skoda',
        '/zapchasti/na-seat',
        '/zapchasti/na-opel',
        '/zapchasti/na-ford'
    ];

    const BASE_URL = 'https://detalika.ru';

    public function init()
    {
        self::$client = new Client();
        parent::init();
    }

    public function actionStart()
    {
        $start = microtime(true);
        $this->stdout('Начало выполнения грабежа данных:'.PHP_EOL, Console::FG_YELLOW);

        $this->saveToDbMakers();
        $this->saveToDbAutos();
        $this->saveToDbCategories();

        $this->createLinksProducts();

        $finish = microtime(true);

        $delta = ($finish - $start) / 60;

        $this->stdout('Всё выполнено шоколадно. Поздравляю!'.PHP_EOL, Console::FG_BLUE);
        $this->stdout('Затраченное время: ' . round($delta, 2) . ' мин' .PHP_EOL, Console::FG_BLUE);
    }

    private function createLinksProducts()
    {
        $categories = file_get_contents(\Yii::getAlias('@console/data/categories_01.json'));
        $data = json_decode($categories, true);

        foreach ($data['data'] as $category) {
            if(isset($category['nodes']) && $category['nodes']) {
                foreach ($category['nodes'] as $subCategory) {
                    if(isset($subCategory['nodes']) && $subCategory['nodes']) {
                        foreach ($subCategory['nodes'] as $subSubCategory) {
                            if($currentId = CatalogCategories::findOne(['alias' => Inflector::slug($subSubCategory['oldText'])])) {
                                $this->catalogCategoryId = $currentId['id'];
                                $this->createLinksProductsWithAuto($subSubCategory['alias']);
                            }
                        }
                    } else {
                        if($currentId = CatalogCategories::findOne(['alias' => Inflector::slug($subCategory['oldText'])])){
                            $this->catalogCategoryId = $currentId['id'];
                            $this->createLinksProductsWithAuto($subCategory['alias']);
                        }
                    }
                }
                break;
            }
            break;
        }
    }

    private function createLinksProductsWithAuto($alias)
    {
        $autoBrands = AutoBrands::find()->all();

        foreach ($autoBrands as $autoBrand) {

            foreach ($autoBrand['autoModels'] as $autoModel) {

                $url = self::BASE_URL . '/zapchasti/na-' . $autoBrand['alias'] . '/'. $autoModel['alias'] . '?detailsCategorieAlias=' . $alias;
                $this->parseListProductsPage($url, 'model', $autoModel['id']);

                foreach ($autoModel['autoGenerations'] as $autoGeneration) {

                    $url = self::BASE_URL . '/zapchasti/na-' . $autoBrand['alias'] . '/'. $autoModel['alias'] . '/' . $autoGeneration['alias']. '/' . $alias;
                    $this->parseListProductsPage($url, 'generation', $autoGeneration['id']);
                    //break;
                }

                break;
            }
            break;
        }
    }

    private function parseListProductsPage($url, $type, $id)
    {
        if( ($request = self::$client->request('GET', $url, ['allow_redirects' => false])) && ($request->getStatusCode() == 200) ) {
            $body = $request->getBody();
            $document = \phpQuery::newDocumentHTML($body);

            $linksProducts = $document->find('.unique-numbers-list .detail-container a.detail');
            foreach ($linksProducts as $linksProduct) {
                if($link = pq($linksProduct)->attr('href')) {

                    $this->stdout('---- Ссылка продукта '.self::BASE_URL . $link . PHP_EOL, Console::FG_GREEN);

                    $this->saveToDbProduct(self::BASE_URL . $link, $type, $id);
                }
            }
        }
    }

    private function saveToDbProduct($link, $type, $autoId)
    {
        $body = self::$client->request('GET', $link)->getBody();
        $document = \phpQuery::newDocumentHTML($body);

        if(Products::findOne(['alias' => Inflector::slug($document->find('h1')->text())])){
            return;
        }

        $newProduct = new Products();
        $newProduct->name = $document->find('h1')->text();
        $newProduct->alias = Inflector::slug($newProduct->name);
        $newProduct->category_id = $this->catalogCategoryId;
        $newProduct->price = intval($document->find('.price-value')->text());

        if($image = $document->find('.product-image')->attr('src')){
            $newImage = explode('/', $image);
            $newImage = explode('.', end($newImage));
            $newImageName = md5($newImage[0] . microtime()) . '.' . $newImage[1];

            if(copy(self::BASE_URL . $image, \Yii::getAlias('@frontend/web/userfiles/products/') . $newImageName)){
                $newProduct->image = $newImageName;
            }
        }

        $maker = $document->find('table.detail-view tr td[itemprop=brand]')->text();
        if( ! $findMaker = Makers::findOne(['name' => $maker])){
            $newMaker = new Makers();
            $newMaker->alias = Inflector::slug($maker);
            $newMaker->name = $maker;
            $newMaker->save();

            $newProduct->maker_id = $newMaker->id;
        } else {
            $newProduct->maker_id = $findMaker->id;
        }

        $newProduct->articul = $document->find('table.detail-view tr:eq(1) td')->text();
        $newProduct->balance = $document->find('table.detail-view tr:eq(3) td')->text();
        $newProduct->barcode = $document->find('table.detail-view tr:eq(4) td')->text();
        $newProduct->text = Html::tag('p',$document->find('div[itemprop=description]')->text());
        if( ! $newProduct->save() ) {
            print_r($newProduct->getErrors());
        }

        if($newProduct->id && ($originNumbers = $document->find('.original-numbers-container a')) ) {
            foreach ($originNumbers as $originNumber) {
                $newOriginNumber = new ProductsOriginalNumbers();
                $newOriginNumber->product_id = $newProduct->id;
                $newOriginNumber->number = pq($originNumber)->text();
                $newOriginNumber->save();
            }
        }

        if($newProduct->id) {
            $productsAutoVia = new ProductsAutoVia();
            $productsAutoVia->product_id = $newProduct->id;
            $productsAutoVia->type = $type;
            $productsAutoVia->auto_id = $autoId;
            $productsAutoVia->save();
        }
    }

    private function saveToDbAutos()
    {
        foreach ($this->autoPages as $page) {
            $body = self::$client->request('GET', self::BASE_URL . $page)->getBody();
            $document = \phpQuery::newDocumentHTML($body);

            if(AutoBrands::findOne(['alias' => str_replace('/zapchasti/na-', '', $page)])) {
                $this->stdout('Info: Модель авто уже есть в БД ', Console::FG_GREEN);
                $this->stdout('«' . $document->find('h1')->text() . '»' . PHP_EOL);
                continue;
            }

            $newBrand = new AutoBrands();
            $newBrand->name = $document->find('h1')->text();
            $newBrand->alias = str_replace('/zapchasti/na-', '', $page);
            $newBrand->save();

            foreach ($document->find('.field-carsmodelalias .models-list .item') as $model) {
                $alias = pq($model)->attr('val');
                if(strstr($alias, '/')) {
                    $chunks = explode('/',$alias);
                    $alias = array_shift($chunks);
                }
                $newModel = new AutoModels();
                $newModel->name = pq($model)->attr('text');
                $newModel->alias = $alias;
                $newModel->brand_id = $newBrand->id;
                $newModel->save();
                $this->saveToDbGenerationsFromUrl(self::BASE_URL . pq($model)->find('a')->attr('href'), $newModel->id);
            }

            $this->stdout('Info: Бренд ' . $newBrand->name . ' сохранён успешно' . PHP_EOL, Console::FG_GREEN);
        }
    }

    /**
     * @param $url
     * @param $modelId
     */
    private function saveToDbGenerationsFromUrl($url, $modelId)
    {
        $body = self::$client->request('GET', $url)->getBody();
        $document = \phpQuery::newDocumentHTML($body);

        foreach ($document->find('.field-carsgenerationalias .models-list .item') as $generation) {
            $newGeneration = new AutoGenerations();
            $newGeneration->name = pq($generation)->attr('text');
            $newGeneration->alias = pq($generation)->attr('val');
            $newGeneration->model_id = $modelId;
            $newGeneration->save();
        }
    }

    private function saveToDbCategories()
    {
        $categories = file_get_contents(\Yii::getAlias('@console/data/categories_01.json'));
        $data = json_decode($categories, true);

        foreach ($data['data'] as $category) {
            if( ! $newCategory = CatalogCategories::findOne(['alias' => Inflector::slug($category['alias'])]) ) {
                $newCategory = new CatalogCategories();
                $newCategory->name = $category['oldText'];
                $newCategory->alias = Inflector::slug($category['alias']);
                $newCategory->catalog_id = $this->catalogId;
                $newCategory->save();
            } else {
                $this->stdout('Info: Категория уже есть в БД ', Console::FG_GREEN);
                $this->stdout('«' . $newCategory->name . '»' . PHP_EOL);
                continue;
            }

            if(isset($category['nodes']) && $category['nodes']){
                foreach ($category['nodes'] as $subCategory) {
                    $newSubCategory = new CatalogCategories();
                    $newSubCategory->name = $subCategory['oldText'];
                    $newSubCategory->alias = Inflector::slug($newSubCategory->name);
                    $newSubCategory->catalog_id = $this->catalogId;
                    $newSubCategory->parent_id = $newCategory->id;
                    $newSubCategory->save();

                    if(isset($subCategory['nodes']) && $subCategory['nodes']) {
                        foreach ($subCategory['nodes'] as $subSubCategory) {
                            $newSubSubCategory = new CatalogCategories();
                            $newSubSubCategory->name = $subSubCategory['oldText'];
                            $newSubSubCategory->alias = Inflector::slug($newSubSubCategory->name);
                            $newSubSubCategory->catalog_id = $this->catalogId;
                            $newSubSubCategory->parent_id = $newSubCategory->id;
                            $newSubSubCategory->save();
                        }
                    }
                }
            }
        }
    }

    private function saveToDbMakers()
    {
        $body = self::$client->request('GET', 'https://detalika.ru/proizvoditeli')->getBody();
        $document = \phpQuery::newDocumentHTML($body);

        $pagLinks = $document->find('.grid-view .pagination a');
        foreach ($pagLinks as $pagLink) {
            $body = self::$client->request('GET', self::BASE_URL . pq($pagLink)->attr('href'))->getBody();
            $document = \phpQuery::newDocumentHTML($body);

            foreach ($document->find('table.table tbody tr td:first-child() > a') as $maker) {
                $alias = Inflector::slug(pq($maker)->text());
                if( ! Makers::findOne(['alias' => $alias])) {
                    $newMaker = new Makers();
                    $newMaker->name = pq($maker)->text();
                    $newMaker->alias = $alias;
                    $newMaker->save();
                }
            }
        }
    }

}