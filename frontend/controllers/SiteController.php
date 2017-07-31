<?php
namespace frontend\controllers;

use common\models\Guestbook;
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
            'sofWorks' => SofWork::find()->asArray()->all(),
            'guestbook' => Guestbook::find()->asArray()->all()
        ]);
    }

    public function actionPage($alias)
    {
        if(!$model = Pages::find()->where(['alias' => $alias])->with(['sliderText' => function($query){
            return $query->with(['sliderTextItems']);
        }])->one()){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $model['text'] = \Yii::$app->parser->parse($model['text']);
        return $this->render('page.twig',[
            'model' => $model
        ]);
    }

    public function actionError()
    {
        return $this->render('error.twig');
    }
}
