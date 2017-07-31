<?php
namespace frontend\widgets;

use common\models\Products as Model;
use yii\base\Widget;

class Products extends Widget
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('/widgets/products.twig', ['model' => Model::find()->asArray()->all()]);
    }
}