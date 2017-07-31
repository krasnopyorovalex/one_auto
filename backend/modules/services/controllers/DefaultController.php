<?php

namespace backend\modules\services\controllers;

use backend\controllers\ModuleController;
use common\models\Services;
use Yii;

/**
 * Default controller for the `services` module
 */
class DefaultController extends ModuleController
{

    public function actionIndex()
    {
        $model = new Services();
        return $this->render('index',[
            'dataProvider' => $this->findData($model::find()->orderBy('pos'))
        ]);
    }

    public function actionUpdatePos()
    {
        $toDb = Yii::$app->request->post('positions');
        foreach($toDb as $id => $pos){
            if($hc = Services::findOne((int)$id)){
                $hc->pos = $pos;
                $hc->update();
            }
        }
        return $this->redirect(Yii::$app->homeUrl . $this->module->id);
    }

}