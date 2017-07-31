<?php

namespace backend\controllers;

use Yii;
use backend\interfaces\IActions;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use backend\interfaces\ModelProviderInterface;
use yii\web\NotFoundHttpException;
//use common\models\Redirects;
use yii\filters\VerbFilter;
use backend\components\FileHelper as FH;

class ModuleController extends SiteController implements IActions
{
    private $_model = null;

    public $actions = [
        'update' => 'Обновление',
        'add' => 'Добавление',
        'delete' => 'Удаление',
    ];

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'add', 'update', 'delete', 'remove-image', 'update-pos'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'remove-image' => ['post'],
                    'update-pos' => ['post'],
                    'upload' => ['post']
                ],
            ],
        ];
    }

    public function init()
    {
        if ($this->module instanceof ModelProviderInterface) {
            $this->_model = $this->module->getModel();
        }
        if(!$this->_model){
            throw new \ErrorException('Не реализован метод getModels() у модуля');
        }
    }

    public function actionIndex()
    {
        $model = $this->_model;
        return $this->render('index',[
            'dataProvider' => $this->findData($model::find())
        ]);
    }

    public function actionAdd()
    {
        $model = new $this->_model;
        $this->loadData($model);
        return $this->render('form',[
            'model' => new $model
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->_model;
        if(!$model = $model::findOne(['id' => $id])){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $this->loadData($model);
        return $this->render('form', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = $this->_model;
        if(Yii::$app->request->isPost && $model::findOne($id)->delete()){
            return $this->redirect(Yii::$app->homeUrl . $this->module->id);
        }
        if(!$model = $model::findOne(['id' => $id])){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $this->render('form', ['model' => $model]);
    }

    /**
     * @param $id
     * @return bool
     */
    public function actionRemoveImage($id)
    {
        $model = $this->_model;
        $model = $model::findOne($id);
        if(FH::removeFile($model->image,$model::PATH)){
            $model->image = '';
            return $model->save();
        }
        return false;
    }

    protected function findData($query)
    {
        return new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
            'pagination' => false
        ]);
    }

    protected function loadData($model, $redirect = null)
    {
        if($model->load(Yii::$app->request->post()) && $model->validate()) {
//            if(!$model->isNewRecord && $model->isAttributeChanged('alias')){
//                $this->insertNewRedirect($model);
//            }
            $model->save();
            if($redirect){
                return $this->redirect($redirect);
            }
            return $this->redirect(Yii::$app->homeUrl . $this->module->id);
        }
    }

    /**
     * @param $model
     * @return bool
     */
    protected function insertNewRedirect($model)
    {
        return (new Redirects([
            'old_alias' => Redirects::DELIMITER.str_replace(['pages/'], '', $model::tableName().Redirects::DELIMITER.$model->getOldAttribute('alias')),
            'new_alias' => Redirects::DELIMITER.str_replace(['pages/'], '', $model::tableName().Redirects::DELIMITER.$model->alias)
        ]))->save();
    }

}