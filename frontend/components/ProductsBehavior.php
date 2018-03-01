<?php

namespace frontend\components;

use common\models\AutoBrands;
use common\models\AutoGenerations;
use common\models\AutoModels;
use common\models\Catalog;
use common\models\Products;
use common\models\ProductsAutoVia;
use yii\base\Behavior;
use yii\db\Query;

/**
 * Class ProductsBehavior
 * @package frontend\components
 */
class ProductsBehavior extends Behavior
{
    private $ids = [];
    private $model;
    private $data;
    private $conditions = [];

    /**
     * @param Catalog $catalog
     * @param $page
     * @param null $brand
     * @param null $model
     * @param null $generation
     */
    public function getProducts(Catalog $catalog, $page, $brand = null, $model = null, $generation = null)
    {
        $this->model = $catalog;
        array_push($this->ids, $catalog->id);
        $this->getCatalogs($catalog['catalogs']);

        $query = Products::find()->where(['category_id' => $this->ids]);
        $count = clone $query;

        if( $productIds = $this->getProductsWithAuto($brand, $model, $generation) ) {
            $ids = array_map(function ($id) {
                $key = key($id);
                return $id[$key];
            }, $productIds);
            $query->andWhere(['id' => $ids]);
        }

        $this->data = [
            'products' => $query
                ->limit(\Yii::$app->params['per_page'])
                ->offset($page)
                ->asArray()
                ->all(),
            'count' => $count->count(),
            'offset' => $page + \Yii::$app->params['per_page']
        ];
    }

    /**
     * @return mixed
     */
    public function json()
    {
        $this->data['products'] = $this->owner->renderAjax('@frontend/widgets/ProductsListForCategory/views/products_list_for_category.twig',[
            'model' => $this->data['products']
        ]);
        return $this->owner->asJson($this->data);
    }

    /**
     * @param $template
     * @return mixed
     */
    public function html(string $template)
    {
        return $this->owner->render($template, [
            'model' => $this->model,
            'products' => $this->data['products'],
            'count' => $this->data['count']
        ]);
    }

    /**
     * @param $catalogs
     */
    private function getCatalogs($catalogs): void
    {
        foreach ($catalogs as $catalog)
        {
            array_push($this->ids, $catalog->id);
            if( $catalogs = $catalog->catalogs ){
                $this->getCatalogs($catalogs);
            }
        }
    }

    /**
     * @param $brand
     * @param $model
     * @param $generation
     * @return array|bool|\yii\db\ActiveRecord[]
     */
    private function getProductsWithAuto($brand, $model, $generation)
    {
        if ( $generation && ($rows = AutoGenerations::find()->where(['alias' => $generation])->all()) ) {

            $this->loadConditions($rows);

        } elseif ( $model && ($rows = AutoModels::find()->where(['alias' => $model])->all()) ) {

            $this->loadConditions($rows);

        } elseif ( $brand && ($rows = AutoBrands::find()->where(['alias' => $brand])->with(['autoModels' => function ($query) {
                return $query->with(['autoGenerations']);
            }])->all()) ) {

            array_map(function ($row) {
                $this->loadConditions($row['autoModels']);
                array_map(function ($autoModel) {
                    $this->loadConditions($autoModel['autoGenerations']);
                }, $row['autoModels']);
            }, (array) $rows);
        } else {
            return false;
        }

        $query = ProductsAutoVia::find()->select('product_id');

        array_map(function ($condition) use ($query) {
            $query->orWhere([
                'type' => $condition['type'],
                'auto_id' => $condition['auto_id']
            ]);
        }, $this->conditions);

        return $query->asArray()->distinct('product_id')->all();
    }

    /**
     * @param $rows
     */
    private function loadConditions($rows): void
    {
        array_map(function ($condition) {
            return array_push($this->conditions, [
                'type' => $condition->getType(),
                'auto_id' => $condition->id
            ]);
        }, $rows);
    }
}