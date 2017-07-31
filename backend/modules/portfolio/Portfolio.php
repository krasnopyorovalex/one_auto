<?php

namespace backend\modules\portfolio;
use backend\interfaces\ModelProviderInterface;
use yii\base\Module;

/**
 * portfolio module definition class
 */
class Portfolio extends Module implements ModelProviderInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\portfolio\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->params['name'] = 'Портфолио';
    }

    /**
     * @return string
     */
    public function getModel()
    {
        return \common\models\Portfolio::className();
    }
}
