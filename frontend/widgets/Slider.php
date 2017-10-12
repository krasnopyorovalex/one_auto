<?php
namespace frontend\widgets;

use yii\base\Widget;

class Slider extends Widget
{

    public $items = [];

    public function run()
    {
        return $this->render('/widgets/slider.twig', ['model' => $this->items]);
    }
}