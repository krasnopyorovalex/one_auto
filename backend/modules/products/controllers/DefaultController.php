<?php

namespace backend\modules\products\controllers;

use backend\controllers\ModuleController;
use common\models\Products;
use Yii;

/**
 * Default controller for the `products` module
 */
class DefaultController extends ModuleController
{
    public function actionUpdatePos()
    {
        $toDb = Yii::$app->request->post('positions');
        foreach($toDb as $id => $pos){
            if($hc = Products::findOne((int)$id)){
                $hc->pos = $pos;
                $hc->update();
            }
        }
        return $this->redirect(Yii::$app->homeUrl . $this->module->id);
    }

    public function actionIndex()
    {
        $model = new Products();
        return $this->render('index',[
            'dataProvider' => $this->findData($model::find()->orderBy('pos'))
        ]);
    }
}
