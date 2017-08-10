<?php

namespace backend\modules\blocks;

use backend\interfaces\ModelProviderInterface;
use yii\base\Module;

/**
 * blocks module definition class
 */
class Blocks extends Module implements ModelProviderInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\blocks\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->params['name'] = 'Блоки сайта';
        // custom initialization code goes here
    }

    /**
     * @return string
     */
    public function getModel()
    {
        return \common\models\Blocks::className();
    }
}
