<?php

namespace backend\modules\catalog\controllers;

use backend\controllers\ModuleController;
use common\models\Catalog;
use common\models\Products;
use core\repositories\CatalogRepository;
use Yii;
use backend\components\FileHelper as FH;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * Default controller for the `catalog` module
 */
class DefaultController extends ModuleController
{
    private $repository;

    public function __construct($id, $module, CatalogRepository $repository, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->repository = $repository;
    }

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(),[
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['list'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ]);
    }

    public function actionIndex()
    {
        return $this->render('index',[
            'dataProvider' => Catalog::find()->where(['parent_id' => null])->with(['products', 'catalogs' => function($query){
                return $query->with(['products', 'catalogs' => function($query){
                    return $query->with(['products', 'catalogs' => function($query){
                        return $query->with(['catalogs', 'products']);
                    }]);
                }]);
            }])->asArray()->all()
        ]);
    }

    public function actionAdd()
    {
        $form = new Catalog();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->repository->save($form);
                return $this->redirect(['index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('form', [
            'model' => $form,
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
            return $this->redirect(['index']);
        }
        return $this->render('form', ['model' => $this->repository->get($id)]);
    }

    /**
     * @param int $id
     * @return string
     */
    public function actionList(int $id)
    {
        Url::remember();
        $products = Products::find()->where(['category_id' => $id])->with(['category']);

        return $this->render('products_list', [
            'dataProvider' => $this->findData($products),
            'category' => Catalog::find()->where(['id' => $id])->one()
        ]);
    }

    /**
     * @param $id
     * @return bool
     */
    public function actionRemoveImage($id)
    {
        /**
         * @var $model Catalog
         */
        $model = $this->repository->get($id);
        if(FH::removeFile($model->image,$model::PATH)){
            $model->image = '';
            return $model->save();
        }
        return false;
    }
}