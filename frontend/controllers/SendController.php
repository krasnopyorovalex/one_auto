<?php
namespace frontend\controllers;

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
        if ( $form->load(\Yii::$app->request->post()) && $form->validate() && $form->sendEmail(\Yii::$app->params['email']) ) {
            return $this->asJson(['status' => 'success', 'message' => \Yii::$app->params['success_send_form']]);
        }
        return $this->asJson(['status' => 'error', 'message' => \Yii::$app->params['error_send_form']]);
    }

}
