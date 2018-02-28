<?php

namespace frontend\widgets\AutoBrands;

use common\models\AutoBrands as Model;
use yii\base\Widget;

class AutoBrands extends Widget
{
    public function run()
    {
        return $this->render('auto_brands.twig', array(
            'model' => Model::find()->asArray()->all()
        ));
    }
}