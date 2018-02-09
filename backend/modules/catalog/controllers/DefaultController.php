<?php

namespace backend\modules\catalog\controllers;

use backend\controllers\ModuleController;
use common\models\Catalog;
use common\models\Category;
use core\repositories\CatalogRepository;
use Yii;
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
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['categories'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
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

    public function actionCategories($id)
    {
        Url::remember();
        return $this->render('categories',[
            'dataProvider' => $this->findData(Category::find()->where(['catalog_id' => $id])),
            'catalog' => $this->repository->get($id)
        ]);
    }
}
