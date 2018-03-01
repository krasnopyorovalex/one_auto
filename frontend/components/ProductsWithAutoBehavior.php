<?php

namespace frontend\components;

use common\models\Catalog;
use common\models\Products;
use yii\base\Behavior;

/**
 * Class ProductsWithAutoBehavior
 * @package frontend\components
 */
class ProductsWithAutoBehavior extends Behavior
{

    private $ids = [];
    private $data;

    public function getProductsWithAuto($category, $brand, $model, $generation, $page = 0)
    {
        $catalog = Catalog::find()->where(['alias' => $category])->limit(1)->one();
        array_push($this->ids, $catalog->id);
        $this->getCatalogs($catalog->catalogs);

        $query = Products::find()->where(['category_id' => $this->ids]);
        $count = clone $query;

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
     * @param $catalogs
     */
    private function getCatalogs($catalogs): void
    {
        foreach ($catalogs as $catalog)
        {
            array_push($this->ids, $catalog->id);
            if($catalog->catalogs){
                $this->getCatalogs($catalog->catalogs);
            }
        }
    }

}