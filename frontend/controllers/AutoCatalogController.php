<?php

namespace frontend\controllers;

use common\models\Catalog;
use frontend\components\ProductsWithAutoBehavior;
use yii\web\NotFoundHttpException;

/**
 * AutoCatalog controller
 *
 * @mixin ProductsWithAutoBehavior
 */
class AutoCatalogController extends SiteController
{

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'class' => ProductsWithAutoBehavior::class
        ];
    }

    /**
     * @param $category
     * @param $brand
     * @param $model
     * @param $generation
     * @param int $page
     * @throws NotFoundHttpException
     */
    public function actionProductsWithAuto($category, $brand, $model, $generation, $page = 0)
    {
        /**
         * @var $model Catalog
         */
        if( ! $model = Catalog::find()->where(['alias' => $category])->with(['parent'])->limit(1)->one() ) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $this->getProductsWithAuto($category, $brand, $model, $generation, $page);
    }

}
