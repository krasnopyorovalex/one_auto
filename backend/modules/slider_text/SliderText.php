<?php

namespace backend\modules\slider_text;
use backend\interfaces\ModelProviderInterface;
use yii\base\Module;

/**
 * slider_text module definition class
 */
class SliderText extends Module implements ModelProviderInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\slider_text\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->params['name'] = 'Слайдер-текст';
        // custom initialization code goes here
    }

    /**
     * @return string
     */
    public function getModel()
    {
        return \common\models\SliderText::className();
    }
}
