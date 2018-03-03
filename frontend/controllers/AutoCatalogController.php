<?php

namespace frontend\controllers;

use common\models\Catalog;
use common\models\CatalogCategories;
use common\models\Products;
use common\models\ProductsAutoVia;
use frontend\components\ProductsBehavior;
use yii\web\NotFoundHttpException;

/**
 * AutoCatalog controller
 *
 * @mixin ProductsBehavior
 */
class AutoCatalogController extends SiteController
{

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'class' => ProductsBehavior::class
        ];
    }

    /**
     * @param $category
     * @param $brand
     * @param $model
     * @param $generation
     * @param int $page
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionProductsWithAuto($category, $brand, $model, $generation, $page = 0)
    {
        /**
         * @var $catalog CatalogCategories
         */
        if( ! $catalog = CatalogCategories::find()->where(['alias' => $category])->with(['catalogCategories'])->limit(1)->one() ) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $this->getProducts($catalog, $page, $brand, $model, $generation);

        if(\Yii::$app->request->isPost){
            return $this->json();
        }

        return $this->html('category_with_auto.twig');
    }

    /**
     * @param $subcategory
     * @param $brand
     * @param $model
     * @param $generation
     * @param int $page
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionProductsWithAutoSubcategory($subcategory, $brand, $model, $generation, $page = 0)
    {
        /**
         * @var $catalog CatalogCategories
         */
        if( ! $catalog = CatalogCategories::find()->where(['alias' => $subcategory])->with(['parent', 'catalogCategories'])->limit(1)->one() ) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $this->getProducts($catalog, $page, $brand, $model, $generation);

        if(\Yii::$app->request->isPost){
            return $this->json();
        }

        return $this->html('category_with_auto_sub.twig');
    }

    /**
     * @param $subsubcategory
     * @param $brand
     * @param $model
     * @param $generation
     * @param int $page
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionProductsWithAutoSubSubcategory($subsubcategory, $brand, $model, $generation, $page = 0)
    {
        /**
         * @var $catalog CatalogCategories
         */
        if( ! $catalog = CatalogCategories::find()->where(['alias' => $subsubcategory])->with(['parent', 'catalogCategories'])->limit(1)->one() ) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $this->getProducts($catalog, $page, $brand, $model, $generation);

        if(\Yii::$app->request->isPost){
            return $this->json();
        }

        return $this->html('category_with_auto_sub_sub.twig');
    }

}
