<?php
namespace frontend\widgets;

use frontend\models\SubscribeForm as Model;
use yii\base\Widget;

class Subscribe extends Widget
{
    public function run()
    {
        return $this->render('/widgets/subscribe.twig', ['modelForm' => new Model()]);
    }
}