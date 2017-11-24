<?php
namespace frontend\widgets;

use yii\base\Widget;

class Landings extends Widget
{

    public $is_landing = 0;

    public function run()
    {
        return $this->render('/widgets/landings.twig', [
            'model' => \common\models\Landings::find()
                ->where(['is_landing' => $this->is_landing])
                ->orderBy('pos')
                ->asArray()
                ->all()
        ]);
    }
}