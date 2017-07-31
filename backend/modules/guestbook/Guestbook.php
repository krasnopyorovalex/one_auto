<?php

namespace backend\modules\guestbook;
use backend\interfaces\ModelProviderInterface;
use yii\base\Module;

/**
 * guestbook module definition class
 */
class Guestbook extends Module implements ModelProviderInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\guestbook\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->params['name'] = 'Отзывы';
        // custom initialization code goes here
    }

    /**
     * @return string
     */
    public function getModel()
    {
        return \common\models\Guestbook::className();
    }
}
