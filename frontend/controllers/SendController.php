<?php
namespace frontend\controllers;

use frontend\models\RecallForm;
use frontend\models\WriteMessageForm;
use yii\filters\VerbFilter;
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
                    'write-message' => ['post'],
                    'recall' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @return \yii\web\Response
     */
    public function actionWriteMessage()
    {
        $form = new WriteMessageForm();
        return $this->asJson(\Yii::$app->sender->sendMessage($form));
    }

    /**
     * @return \yii\web\Response
     */
    public function actionRecall()
    {
        $form = new RecallForm();
        return $this->asJson(\Yii::$app->sender->sendMessage($form));
    }

}
