<?php

namespace backend\modules\articles;

use backend\interfaces\ModelProviderInterface;
use yii\base\Module;

/**
 * articles module definition class
 */
class Articles extends Module implements ModelProviderInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\articles\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->params['name'] = 'Статьи';
    }

    /**
     * @return string
     */
    public function getModel()
    {
        return \common\models\Articles::className();
    }
}
