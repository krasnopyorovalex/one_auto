<?php

namespace backend\modules\news\controllers;

use backend\controllers\ModuleController;
use common\models\News;

/**
 * Default controller for the `news` module
 */
class DefaultController extends ModuleController
{
    public function actionIndex()
    {
        return $this->render('index',[
            'dataProvider' => $this->findData(News::find()->orderBy('date DESC'))
        ]);
    }
}
