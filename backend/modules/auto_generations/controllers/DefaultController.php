<?php

namespace backend\modules\auto_generations\controllers;

use yii\web\Controller;

/**
 * Default controller for the `auto_generations` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
