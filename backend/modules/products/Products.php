<?php

namespace backend\modules\products;

use backend\interfaces\ModelProviderInterface;
use yii\base\Module;

/**
 * products module definition class
 */
class Products extends Module implements ModelProviderInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\products\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->params['name'] = 'Продукты';
        // custom initialization code goes here
    }

    /**
     * @return string
     */
    public function getModel()
    {
        return \common\models\Products::className();
    }
}
