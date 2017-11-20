<?php
namespace frontend\controllers;

use common\models\Articles;
use yii\web\NotFoundHttpException;

/**
 * Articles Controller
 */
class ArticlesController extends SiteController
{
    /**
     * @param $alias
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionShow($alias)
    {
        if(!$model = Articles::find()->where(['alias' => $alias])->one()){
            throw new NotFoundHttpException();
        }
        //$model['text'] = \Yii::$app->parser->parse($model['text']);
        return $this->render('article.twig',[
            'model' => $model
        ]);
    }
}
