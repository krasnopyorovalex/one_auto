<?php
namespace frontend\widgets;

use frontend\models\OrderForm as Model;
use yii\base\Widget;

class Order extends Widget
{
    public function run()
    {
        return $this->render('/widgets/order.twig', ['modelForm' => new Model()]);
    }
}