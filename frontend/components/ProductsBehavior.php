<?php

namespace frontend\components;

use common\models\Catalog;
use common\models\Products;
use yii\base\Behavior;

/**
 * Class ProductsBehavior
 * @package frontend\components
 */
class ProductsBehavior extends Behavior
{
    private $ids = [];
    private $model;
    private $data;

    /**
     * @param Catalog $catalog
     * @param $page
     */
    public function getProducts(Catalog $catalog, $page)
    {
        $this->model = $catalog;
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
            if($catalog->catalogs){
                $this->getCatalogs($catalog->catalogs);
            }
        }
    }
}