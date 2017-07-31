<?php
namespace frontend\widgets;

use common\models\Menu as Model;
use yii\base\Widget;

class Menu extends Widget
{
    public $sysName;
    public $cssClass = '';

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('/widgets/menu.twig', [
            'model' => Model::find()->where(['sys_name' => $this->sysName])->with(['menuItems'])->asArray()->one(),
            'cssClass' => $this->cssClass
        ]);
    }
}