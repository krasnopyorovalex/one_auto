<?php
namespace frontend\widgets;

use frontend\models\WriteMessageForm as Model;
use yii\base\Widget;

class WriteMessage extends Widget
{

    public function run()
    {
        return $this->render('/widgets/write_message.twig', ['modelForm' => new Model()]);
    }
}