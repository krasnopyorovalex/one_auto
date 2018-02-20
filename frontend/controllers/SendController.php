<?php
namespace frontend\controllers;

use frontend\models\OrderForm;
use frontend\models\RecallForm;
use frontend\models\SubscribeForm;
use frontend\models\FormOrder;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Send Controller
 */
class SendController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'order' => ['post']
                ],
            ],
        ];
    }

    /**
     * @return \yii\web\Response
     */
    public function actionOrder()
    {
        \Yii::$app->sender->sendMessage(new FormOrder());
        \Yii::$app->session->setFlash('message', \Yii::$app->params['success_send_form']);
        return $this->redirect(\Yii::$app->request->referrer);
    }

}
