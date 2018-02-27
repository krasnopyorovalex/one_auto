<?php

namespace frontend\components;

use common\models\AutoBrands;
use common\models\Catalog;
use yii\base\Behavior;

/**
 * Class CatalogAndBrandsBehavior
 * @package frontend\components
 */
class CatalogAndBrandsBehavior extends Behavior
{
    /**
     * @param $alias
     * @param $page
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getCatalogOrBrand($alias, $page)
    {
        $model = AutoBrands::find()
            ->where(['alias' => $alias])
            ->limit(1)
            ->one();

        return $model ?? Catalog::find()
                ->where(['alias' => $alias])
                ->with(['parent', 'products' => function ($query) use ($page) {
                    return $query
                        ->limit(\Yii::$app->params['per_page'])
                        ->offset($page);
                }])
                ->limit(1)
                ->one();
    }

}