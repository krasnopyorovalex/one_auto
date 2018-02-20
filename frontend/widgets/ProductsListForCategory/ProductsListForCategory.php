<?php

namespace frontend\widgets\ProductsListForCategory;

use yii\base\Widget;

class ProductsListForCategory extends Widget
{
    public $items;
    public $count;

    public function run()
    {
        return $this->render('products_list_for_category.twig', [
            'model' => $this->items,
            'count' => $this->count
        ]);
    }
}