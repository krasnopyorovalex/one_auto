<?php
namespace frontend\widgets;

use common\models\Menu as Model;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

class Menu extends Widget
{
    public $sysName;
    public $cssClass = '';

    private static $menus;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        if(!self::$menus){
            self::$menus = ArrayHelper::map(Model::find()->with(['menuItems'])->asArray()->all(), 'sys_name', 'menuItems');
        }
        return $this->render('/widgets/menu.twig', [
            'model' => self::$menus[$this->sysName],
            'cssClass' => $this->cssClass
        ]);
    }
}