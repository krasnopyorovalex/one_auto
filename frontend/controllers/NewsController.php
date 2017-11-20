<?php
namespace frontend\controllers;

use common\models\News;
use yii\web\NotFoundHttpException;

/**
 * News Controller
 */
class NewsController extends SiteController
{
    /**
     * @param $alias
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionShow($alias)
    {
        if(!$model = News::find()->where(['alias' => $alias])->one()){
            throw new NotFoundHttpException();
        }
        return $this->render('new.twig',[
            'model' => $model
        ]);
    }
}
