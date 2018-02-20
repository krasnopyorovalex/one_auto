<?php

namespace frontend\controllers;

use common\models\Pages;
use common\models\Subdomains;
use yii\helpers\ArrayHelper;
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

    /**
     * @param $alias
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionShow($alias)
    {
        if(!$model = Pages::find()->where(['alias' => $alias])->one()){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $this->render('page.twig',[
            'model' => $model
        ]);
    }

    /**
     * @return string
     */
    public function actionError()
    {
        return $this->render('error.twig');
    }

    /**
     * @param $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        //$subdomain = Subdomains::findOne(['domain_name' => \Yii::$app->request->hostName]);
        $subdomain = Subdomains::findOne(['domain_name' => 'moscow']);
        \Yii::$app->params['phone'] = $subdomain->phone;
        \Yii::$app->params['address'] = $subdomain->address;
        \Yii::$app->params['subdomains'] = ArrayHelper::map(Subdomains::find()->asArray()->all(), 'domain_name', function($item){
            return json_decode($item['cases_json']);
        });
        return true;
    }
}
