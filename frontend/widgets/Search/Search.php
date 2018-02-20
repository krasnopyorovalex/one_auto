<?php

namespace frontend\widgets\Search;

use frontend\widgets\Search\form\FormSearch;
use yii\base\Widget;

class Search extends Widget
{
    public function run()
    {
        return $this->render('search.twig', [
            'model' => new FormSearch()
        ]);
    }
}