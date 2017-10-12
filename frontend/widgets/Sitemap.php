<?php
namespace frontend\widgets;

use common\models\Pages as Model;
use yii\base\Widget;

class Sitemap extends Widget
{

    public function run()
    {
        return $this->render('/widgets/sitemap.twig', [
            'model' => Model::find()->asArray()->all(),
            'services' => \common\models\Services::find()->asArray()->all()
        ]);
    }
}