<?php

namespace backend\modules\products\controllers;

use backend\controllers\SiteController;
use common\models\AutoModels;
use common\models\ProductsOld;
use common\models\ProductsOptions;
use common\models\SubCategory;
use core\repositories\ProductsRepository;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use backend\components\FileHelper as FH;

/**
 * Default controller for the `products` module
 */
class DefaultController extends SiteController
{

    private $repository;

    public function __construct($id, $module, ProductsRepository $repository, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->repository = $repository;
    }

    public function actionAdd($id)
    {
        $form = new ProductsOld();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->repository->save($form);
                return $this->redirect(Url::previous());
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        $subcategory = SubCategory::find()->where(['id' => $id])->with(['category' => function($query){
            return $query->with(['catalog']);
        }])->one();
        return $this->render('form', [
            'model' => $form,
            'catalog' => $subcategory['category']['catalog'],
            'category' => $subcategory['category'],
            'subcategory' => $subcategory,
            'options' => ProductsOptions::find()->asArray()->all(),
            'productOptions' => [],
            'autoModels' => ArrayHelper::map(AutoModels::find()->with(['brand'])->asArray()->all(),'id', function ($item){
                return $item['brand']['name'] . ' - ' . $item['name'];
            })
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        if(!$form = $this->repository->get($id)){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $this->loadData($form, Url::previous());
        return $this->render('form', [
            'model' => $form,
            'catalog' => $form['subcategory']['category']['catalog'],
            'category' => $form['subcategory']['category'],
            'subcategory' => $form['subcategory'],
            'options' => ProductsOptions::find()->asArray()->all(),
            'productOptions' => ArrayHelper::map($form['productsOptionsVias'], 'option_id', 'value'),
            'autoModels' => ArrayHelper::map(AutoModels::find()->with(['brand'])->asArray()->all(),'id', function ($item){
                return $item['brand']['name'] . ' - ' . $item['name'];
            })
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(Yii::$app->request->isPost){
            try {
                $this->repository->remove($id);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Url::previous());
        }
        $form = $this->repository->get($id);
        return $this->render('form', [
            'model' => $form,
            'catalog' => $form['subcategory']['category']['catalog'],
            'category' => $form['subcategory']['category'],
            'subcategory' => $form['subcategory'],
            'options' => ProductsOptions::find()->asArray()->all(),
            'productOptions' => ArrayHelper::map($form['productsOptionsVias'], 'option_id', 'value'),
            'autoModels' => ArrayHelper::map(AutoModels::find()->with(['brand'])->asArray()->all(),'id', function ($item){
                return $item['brand']['name'] . ' - ' . $item['name'];
            })
        ]);
    }

    /**
     * @param $id
     * @return bool
     */
    public function actionRemoveImage($id)
    {
        /**
         * @var $model ProductsOld
         */
        $model = $this->repository->get($id);
        if(FH::removeFile($model->image,$model::PATH)){
            $model->image = '';
            return $model->save();
        }
        return false;
    }

}
