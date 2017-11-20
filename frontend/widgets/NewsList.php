<?php

namespace frontend\widgets;

use common\models\News;
use yii\base\Widget;

class NewsList extends Widget
{
    const MAX_COUNT = 8;

    public function run()
    {
        return $this->render('/widgets/news_list.twig', [
            'model' => News::find()->orderBy('date DESC')->limit(self::MAX_COUNT)->asArray()->all()
        ]);
    }
}