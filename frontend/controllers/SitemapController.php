<?php
namespace frontend\controllers;

use common\models\Pages;
use common\models\Services;
use yii\web\Response;

/**
 * Sitemap Controller
 */
class SitemapController extends SiteController
{
    /**
     * @return string
     */
    public function actionXml()
    {
        $this->layout = false;
        \Yii::$app->response->format = Response::FORMAT_RAW;
        $headers = \Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml');

        return $this->render('sitemap.twig',[
            'pages' => Pages::find()->where(['<>','alias','index'])->asArray()->all(),
            'services' => Services::find()->orderBy('pos')->asArray()->all()
        ]);
    }
}
