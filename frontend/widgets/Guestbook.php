<?php
namespace frontend\widgets;

use yii\base\Widget;

class Guestbook extends Widget
{
    public function run()
    {
        return $this->render('/widgets/guestbook.twig', [
            'guestbook' => \common\models\Guestbook::find()->orderBy('pos')->asArray()->all()
        ]);
    }
}