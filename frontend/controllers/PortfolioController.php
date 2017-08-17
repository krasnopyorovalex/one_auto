<?php
namespace frontend\controllers;

use common\models\Portfolio;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * Portfolio Controller
 */
class PortfolioController extends SiteController
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'show' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionShow($id)
    {
        if(!$model = Portfolio::find()->where(['id' => $id])->with(['portfolioImages'])->one()){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $this->renderAjax('portfolio.twig',[
            'model' => $model
        ]);
    }
}
