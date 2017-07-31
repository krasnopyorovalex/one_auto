<?php

namespace backend\modules\slider_text\controllers;

use backend\controllers\ModuleController;
use common\models\SliderText;
use common\models\SliderTextItems;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * Default controller for the `menu` module
 */
class ItemsController extends ModuleController
{

    public $actions = [
        'edit-item' => 'Обновление пункта',
        'add-item' => 'Добавление пункта',
        'delete-item' => 'Удаление пункта',
    ];

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(),[
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['items','add-item','edit-item','delete-item','update-pos-items'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'update-pos-items' => ['post'],
                ],
            ],
        ]);
    }

    public function actionItems($id)
    {
        Url::remember();
        return $this->render('index',[
            'dataProvider' =>  $this->findData(SliderTextItems::find()->where(['slider_text_id' => $id])->orderBy('pos')),
            'slider_text' => SliderText::findOne($id)
        ]);
    }

    public function actionAddItem($id)
    {
        $model = new SliderTextItems;
        if($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            return $this->redirect(Url::previous());
        }
        return $this->render('form',[
            'model' =>  $model,
            'slider_text_id' => $id,
            'slider_text' => SliderText::findOne($id)
        ]);
    }

    public function actionEditItem($id)
    {
        $model = SliderTextItems::find()->where(['id' => $id])->one();
        if($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            return $this->redirect(Url::previous());
        }
        return $this->render('form',[
            'model' =>  $model,
            'slider_text' => SliderText::findOne($id)
        ]);
    }

    public function actionDeleteItem($id)
    {
        $model = SliderTextItems::findOne($id);
        if(Yii::$app->request->isPost && $model->delete()){
            return $this->redirect(Url::previous());
        }
        return $this->render('form', [
            'model' => $model,
            'slider_text' => SliderText::findOne($id)
        ]);
    }

    public function actionUpdatePosItems()
    {
        $toDb = Yii::$app->request->post('positions');
        foreach($toDb as $id => $pos){
            if($hc = SliderTextItems::findOne((int)$id)){
                $hc->pos = $pos;
                $hc->update();
            }
        }
        return $this->redirect(Url::previous());
    }

}
