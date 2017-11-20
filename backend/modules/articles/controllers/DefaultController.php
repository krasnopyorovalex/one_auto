<?php

namespace backend\modules\articles\controllers;

use backend\controllers\ModuleController;
use common\models\Articles;

/**
 * Default controller for the `news` module
 */
class DefaultController extends ModuleController
{
    public function actionIndex()
    {
        return $this->render('index',[
            'dataProvider' => $this->findData(Articles::find()->orderBy('date DESC'))
        ]);
    }
}
