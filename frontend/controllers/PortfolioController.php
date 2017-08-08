<?php
namespace frontend\controllers;

use common\models\Portfolio;
use yii\filters\VerbFilter;

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
                    'show' => ['post', 'get'],
                ],
            ],
        ];
    }

    /**
     * @param $id
     * @return string
     */
    public function actionShow($id)
    {
        $model = Portfolio::find()->where(['id' => $id])->with(['portfolioImages'])->one();
        return $this->renderAjax('portfolio.twig',[
            'model' => $model
        ]);
    }
}
