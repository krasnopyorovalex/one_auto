<?php

namespace backend\modules\sof_work;
use backend\interfaces\ModelProviderInterface;
use yii\base\Module;

/**
 * sof_work module definition class
 */
class SofWork extends Module implements ModelProviderInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\sof_work\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->params['name'] = 'Этапы работы';
        // custom initialization code goes here
    }

    /**
     * @return string
     */
    public function getModel()
    {
        return \common\models\SofWork::className();
    }
}
