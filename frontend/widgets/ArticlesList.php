<?php

namespace frontend\widgets;

use common\models\Articles;
use yii\base\Widget;

class ArticlesList extends Widget
{
    const MAX_COUNT = 8;

    public function run()
    {
        return $this->render('/widgets/articles_list.twig', [
            'model' => Articles::find()->orderBy('date DESC')->limit(self::MAX_COUNT)->asArray()->all()
        ]);
    }
}