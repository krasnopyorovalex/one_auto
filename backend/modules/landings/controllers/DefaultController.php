<?php

namespace backend\modules\landings\controllers;

use backend\controllers\ModuleController;
use common\models\Landings;
use Yii;


/**
 * Default controller for the `landings` module
 */
class DefaultController extends ModuleController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index',[
            'dataProvider' => $this->findData(Landings::find()->orderBy('pos'))
        ]);
    }

    public function actionUpdatePos()
    {
        $toDb = Yii::$app->request->post('positions');
        foreach($toDb as $id => $pos){
            if($hc = Landings::findOne((int)$id)){
                $hc->pos = $pos;
                $hc->update();
            }
        }
        return $this->redirect(Yii::$app->homeUrl . $this->module->id);
    }
}
