<?php

namespace frontend\controllers;

use common\models\Catalog;

/**
 * Catalog controller
 */
class CatalogController extends SiteController
{

    /**
     * @param $alias
     * @param int $page
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionShow($alias, $page = 0)
    {
        if(!$model = Catalog::find()->where(['alias' => $alias])->with(['categories'])->one()){
            return parent::actionShow($alias);
        }

        return $this->render('page.twig',[
            'model' => $model
        ]);
    }
}
