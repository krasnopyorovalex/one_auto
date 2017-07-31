<?php
namespace frontend\widgets;

use common\models\Services as Model;
use yii\base\Widget;

class Services extends Widget
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('/widgets/services.twig', ['model' => Model::find()->orderBy('pos')->asArray()->all()]);
    }
}