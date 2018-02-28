<?php

namespace frontend\controllers;

use common\models\Products;
use yii\web\NotFoundHttpException;

/**
 * Product controller
 */
class ProductController extends SiteController
{

    /**
     * @param $alias
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionShow($alias)
    {
        if( ! $model = Products::find()->where(['alias' => $alias])->with(['category'])->limit(1)->one() ){
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('page.twig', [
            'model' => $model
        ]);
    }
}
