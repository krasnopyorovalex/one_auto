<?php

namespace frontend\controllers;

use common\models\Catalog;
use yii\web\NotFoundHttpException;
use frontend\components\ProductsBehavior;

/**
 * AutoCatalog controller
 *
 * @mixin ProductsBehavior
 */
class AutoCatalogController extends SiteController
{

    public function actionForBrand($category, $brand, $model, $page = 0)
    {

    }

}
