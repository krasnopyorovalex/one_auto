<?php
namespace frontend\widgets;

use common\models\Blocks as Model;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

class Blocks extends Widget
{

    public $id;
    private static $blocks;

    public function run()
    {
        if(!self::$blocks){
            self::$blocks = ArrayHelper::index(Model::find()->asArray()->all(), function ($item) {
                return '{block_'.$item['id'].'}';
            });
        }
        return $this->render('/widgets/blocks.twig', ['model' => self::$blocks[$this->id]]);
    }
}