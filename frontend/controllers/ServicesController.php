<?php
namespace frontend\controllers;

use common\models\Services;

/**
 * Services Controller
 */
class ServicesController extends SiteController
{
    /**
     * @param $alias
     * @return string
     */
    public function actionShow($alias)
    {
        $model = Services::find()->where(['alias' => $alias])->one();
        $model['text'] = \Yii::$app->parser->parse($model['text']);
        return $this->render('service.twig',[
            'model' => $model
        ]);
    }
}
