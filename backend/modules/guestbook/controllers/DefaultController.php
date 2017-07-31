<?php

namespace backend\modules\guestbook\controllers;

use backend\controllers\ModuleController;
use common\models\Guestbook as Model;
use Yii;

/**
 * Default controller for the `guestbook` module
 */
class DefaultController extends ModuleController
{

    public function actionIndex()
    {
        $model = new Model();
        return $this->render('index',[
            'dataProvider' => $this->findData($model::find()->orderBy('pos'))
        ]);
    }

    public function actionUpdatePos()
    {
        $toDb = Yii::$app->request->post('positions');
        foreach($toDb as $id => $pos){
            if($hc = Model::findOne((int)$id)){
                $hc->pos = $pos;
                $hc->update();
            }
        }
        return $this->redirect(Yii::$app->homeUrl . $this->module->id);
    }

}