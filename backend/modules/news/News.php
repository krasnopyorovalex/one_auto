<?php

namespace backend\modules\news;

use backend\interfaces\ModelProviderInterface;
use yii\base\Module;

/**
 * news module definition class
 */
class News extends Module implements ModelProviderInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\news\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->params['name'] = 'Новости';
    }

    /**
     * @return string
     */
    public function getModel()
    {
        return \common\models\News::className();
    }
}
