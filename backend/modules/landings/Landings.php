<?php

namespace backend\modules\landings;

use backend\interfaces\ModelProviderInterface;
use yii\base\Module;

/**
 * landings module definition class
 */
class Landings extends Module implements ModelProviderInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\landings\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->params['name'] = 'Лендосы';
        // custom initialization code goes here
    }

    /**
     * @return string
     */
    public function getModel()
    {
        return \common\models\Landings::className();
    }
}
