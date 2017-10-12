<?php
namespace frontend\widgets;

use frontend\models\RecallForm as Model;
use yii\base\Widget;

class Recall extends Widget
{
    public function run()
    {
        return $this->render('/widgets/recall.twig', ['modelForm' => new Model()]);
    }
}