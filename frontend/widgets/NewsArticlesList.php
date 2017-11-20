<?php

namespace frontend\widgets;

use common\models\Articles;
use common\models\News;
use yii\base\Widget;

class NewsArticlesList extends Widget
{
    public function run()
    {
        return $this->render('/widgets/news_articles_list.twig', [
            'news' => News::find()->orderBy('date DESC')->limit(2)->asArray()->all(),
            'articles' => Articles::find()->orderBy('date DESC')->limit(2)->asArray()->all()
        ]);
    }
}