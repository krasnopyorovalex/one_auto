<?php
namespace frontend\widgets;

use common\models\Services as Model;
use yii\base\Widget;

class Services extends Widget
{

    public $exclude = null;

    public function run()
    {
        $model = Model::find()->orderBy('pos');
        if($this->exclude){
            $model->where(['<>','id', $this->exclude]);
        }
        return $this->render('/widgets/services.twig', ['model' => $model->asArray()->all()]);
    }
}