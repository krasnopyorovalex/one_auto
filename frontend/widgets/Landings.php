<?php
namespace frontend\widgets;

use yii\base\Widget;

class Landings extends Widget
{

    public function run()
    {
        return $this->render('/widgets/landings.twig', [
            'model' => \common\models\Landings::find()->asArray()->all()
        ]);
    }
}