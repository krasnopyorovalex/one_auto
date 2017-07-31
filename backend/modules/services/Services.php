<?php

namespace backend\modules\services;
use backend\interfaces\ModelProviderInterface;
use yii\base\Module;

/**
 * services module definition class
 */
class Services extends Module implements ModelProviderInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\services\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->params['name'] = 'Услуги';
    }

    /**
     * @return string
     */
    public function getModel()
    {
        return \common\models\Services::className();
    }
}
