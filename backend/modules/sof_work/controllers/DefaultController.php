<?php

namespace backend\modules\sof_work\controllers;

use backend\controllers\ModuleController;
use common\models\SofWork;
use Yii;

/**
 * Default controller for the `sof_work` module
 */
class DefaultController extends ModuleController
{

    public function actionIndex()
    {
        $model = new SofWork();
        return $this->render('index',[
            'dataProvider' => $this->findData($model::find()->orderBy('pos'))
        ]);
    }

    public function actionUpdatePos()
    {
        $toDb = Yii::$app->request->post('positions');
        foreach($toDb as $id => $pos){
            if($hc = SofWork::findOne((int)$id)){
                $hc->pos = $pos;
                $hc->update();
            }
        }
        return $this->redirect(Yii::$app->homeUrl . $this->module->id);
    }

}