<?php

namespace backend\modules\redirects;
use backend\interfaces\ModelProviderInterface;
use yii\base\Module;

/**
 * redirects module definition class
 */
class Redirects extends Module implements ModelProviderInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\redirects\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->params['name'] = 'Редиректы';
        // custom initialization code goes here
    }

    /**
     * @return string
     */
    public function getModel()
    {
        return \common\models\Redirects::className();
    }

}
