<?php

namespace core\repositories;

use common\models\ProductsOld;
use yii\db\ActiveRecord;

class ProductsRepository
{
    public function get($id): ActiveRecord
    {
        if (!$product = ProductsOld::find()->where(['id' => $id])->with(['autoModels','productsOptionsVias','subcategory' => function($query){
            return $query->with(['category' => function($query){
                return $query->with(['catalog']);
            }]);
        }])->one()) {
            throw new NotFoundException('Product is not found.');
        }
        return $product;
    }

    public function save(ActiveRecord $product): void
    {
        if (!$product->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove($id): void
    {
        if (!ProductsOld::findOne($id)->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}