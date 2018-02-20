<?php

namespace frontend\controllers;

use common\models\Catalog;
use common\models\Products;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * Product controller
 */
class ProductController extends SiteController
{

    /**
     * @param $alias
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionShow($alias)
    {
        if(!$model = Products::find()->where(['alias' => $alias])->with(['options','productsOptionsVias','subcategory' => function($query){
            return $query->with(['category' => function($query){
                return $query->with(['catalog']);
            }]);
        }])->asArray()->one()){
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model['catalog'] = Catalog::find()->where(['id' => $model['subcategory']['category']['catalog']['id']])->with(['categories' => function($query){
            return $query->with(['subCategories']);
        }])->one();

        return $this->render('page.twig',[
            'model' => $model,
            'options' => ArrayHelper::map($model['productsOptionsVias'],'option_id','value')
        ]);
    }
}
