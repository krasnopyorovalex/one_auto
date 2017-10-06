<?php
namespace frontend\controllers;

use common\models\Pages;
use common\models\SofWork;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{

    public $layout = 'main.twig';

    /**
     * @param string $alias
     * @return string
     */
    public function actionIndex($alias = 'index')
    {
        $model = Pages::find()->where(['alias' => $alias])->with(['sliderText' => function($query){
            return $query->with(['sliderTextItems']);
        }])->one();
        $model['text'] = \Yii::$app->parser->parse($model['text']);
        return $this->render('index.twig',[
            'model' => $model,
            'sofWorks' => SofWork::find()->orderBy('pos')->asArray()->all()
        ]);
    }

    public function actionPage($alias)
    {
        if(!$model = Pages::find()->where(['alias' => $alias])->with(['sliderText' => function($query){
            return $query->with(['sliderTextItems']);
        }])->one()){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $guestbook = \Yii::$app->parser->parseGuestbook($model['text']);
        $model['text'] = \Yii::$app->parser->parse($model['text']);
        return $this->render('page.twig',[
            'model' => $model,
            'guestbook' => $guestbook
        ]);
    }

    public function actionError()
    {
        return $this->render('error.twig');
    }
}
