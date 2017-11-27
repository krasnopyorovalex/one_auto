<?php
namespace frontend\widgets;

use common\models\Pages as Model;
use common\models\Articles;
use common\models\Services;
use yii\base\Widget;

class Sitemap extends Widget
{

    public function run()
    {
        return $this->render('/widgets/sitemap.twig', [
            'model' => Model::find()->asArray()->all(),
            'services' => Services::find()->asArray()->all(),
            'articles' => Articles::find()->asArray()->all()
        ]);
    }
}