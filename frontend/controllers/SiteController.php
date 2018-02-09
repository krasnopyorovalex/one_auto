<?php
namespace frontend\controllers;

use common\models\Pages;
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
        $model = Pages::find()->where(['alias' => $alias])->one();
        return $this->render('index.twig',[
            'model' => $model
        ]);
    }

    public function actionPage($alias)
    {
        if(!$model = Pages::find()->where(['alias' => $alias])->one()){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $this->render('page.twig',[
            'model' => $model
        ]);
    }

    public function actionError()
    {
        return $this->render('error.twig');
    }
}
