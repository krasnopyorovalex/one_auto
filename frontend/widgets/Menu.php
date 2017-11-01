<?php
namespace frontend\widgets;

use common\models\Menu as Model;
use common\models\MenuItems;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

class Menu extends Widget
{
    public $sysName;
    public $cssClass = '';

    private static $menus;

    public function run()
    {
        if(!self::$menus){
            self::$menus = ArrayHelper::map(Model::find()->with(['menuItems' => function($query){
                return $query->where(['parent_id' => MenuItems::NOT_PARENT])->with(['menuItems' => function($query){
                    return $query->orderBy('pos');
                }])->orderBy('pos');
            }])->asArray()->all(), 'sys_name', 'menuItems');
        }
        return $this->render('/widgets/menu.twig', [
            'model' => self::$menus[$this->sysName],
            'cssClass' => $this->cssClass
        ]);
    }
}