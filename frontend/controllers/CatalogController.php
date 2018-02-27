<?php

namespace frontend\controllers;

use frontend\components\CatalogAndBrandsBehavior;
use yii\web\NotFoundHttpException;

/**
 * Catalog controller
 *
 * @mixin CatalogAndBrandsBehavior
 */
class CatalogController extends SiteController
{

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'class' => CatalogAndBrandsBehavior::class
        ];
    }

    /**
     * @param $catalog
     * @param $subcategory
     * @param int $page
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionShow($catalog, $subcategory, $page = 0)
    {
        if( ! $model = $this->getCatalogOrBrand($subcategory, $page) ) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render($model['template'], [
            'model' => $model
        ]);
    }
}
