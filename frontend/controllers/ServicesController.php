<?php
namespace frontend\controllers;

use common\models\Services;
use yii\web\NotFoundHttpException;

/**
 * Services Controller
 */
class ServicesController extends SiteController
{
    /**
     * @param $alias
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionShow($alias)
    {
        if(!$model = Services::find()->where(['alias' => $alias])->one()){
            throw new NotFoundHttpException();
        }
        $model['text'] = \Yii::$app->parser->parse($model['text']);
        return $this->render('service.twig',[
            'model' => $model
        ]);
    }
}
