<?php

namespace console\controllers;

use common\models\AutoBrands;
use common\models\AutoGenerations;
use common\models\AutoModels;
use common\models\CatalogCategories;
use common\models\Products;
use GuzzleHttp\Client;
use yii\console\Controller;
use yii\helpers\Console;
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
        $this->stdout('Начало выполнения грабежа данных:'.PHP_EOL, Console::FG_YELLOW);

        $this->saveToDbMakers();
        //$this->saveToDbAutos();
        //$this->saveToDbCategories();
        //$this->createLinksProducts();

        $this->stdout('Всё выполнено шоколадно. Поздравляю!'.PHP_EOL, Console::FG_BLUE);
    }

    private function saveToDbMakers()
    {
        $body = self::$client->request('GET', 'https://detalika.ru/proizvoditeli')->getBody();
        $document = \phpQuery::newDocumentHTML($body);

        $pagLinks = $document->find('.pagination a');
        foreach ($pagLinks as $pagLink) {
            echo pq($pagLink)->text() . PHP_EOL;
        }
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
                            $this->catalogCategoryId = $subSubCategory['id'];
                            $this->createLinksProductsWithAuto($subSubCategory['alias']);
                        }
                    } else {
                        $this->catalogCategoryId = $subCategory['id'];
                        $this->createLinksProductsWithAuto($subCategory['alias']);
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

//                foreach ($autoModel['autoGenerations'] as $autoGeneration) {
//
//                    $url = self::BASE_URL . '/zapchasti/na-' . $autoBrand['alias'] . '/'. $autoModel['alias'] . '/' . $autoGeneration['alias']. '/' . $alias;
//                    //$this->stdout('Info: '.$url . PHP_EOL, Console::FG_GREEN);
//                    break;
//                }

                break;
            }
            break;
        }
    }

    private function parseListProductsPage($url, $type, $id)
    {
        $body = self::$client->request('GET', $url)->getBody();
        $document = \phpQuery::newDocumentHTML($body);

        $linksProducts = $document->find('.unique-numbers-list .detail-container a.detail');

        foreach ($linksProducts as $linksProduct) {
            if($link = pq($linksProduct)->attr('href')) {
                $this->saveToDbProduct(self::BASE_URL . $link, $type, $id);
            }
        }
    }

    private function saveToDbProduct($link, $type, $id) {
        $body = self::$client->request('GET', $link)->getBody();
        $document = \phpQuery::newDocumentHTML($body);

        if(Products::findOne(['alias' => Inflector::slug($document->find('h1')->text())])){
            return;
        }

        $newProduct = new Products();
        $newProduct->name = $document->find('h1')->text();
        $newProduct->alias = Inflector::slug($newProduct->name);
        $newProduct->category_id = $this->catalogCategoryId;

        exit();
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

            foreach ($document->find('.field-carsmodelalias .models-list .item a') as $model) {
                $newModel = new AutoModels();
                $newModel->name = pq($model)->text();
                $newModel->alias = Inflector::slug($newModel->name);
                $newModel->brand_id = $newBrand->id;
                $newModel->save();
                $this->saveToDbGenerationsFromUrl(self::BASE_URL . pq($model)->attr('href'), $newModel->id);
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

        foreach ($document->find('.field-carsgenerationalias .models-list .item a') as $generation) {
            $newGeneration = new AutoGenerations();
            $newGeneration->name = pq($generation)->find('b')->text();
            $newGeneration->alias = Inflector::slug($newGeneration->name);
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
}