<?php

namespace backend\modules\portfolio\controllers;

use backend\components\UploadInterface;
use backend\controllers\ModuleController;
use common\models\Portfolio;
use common\models\PortfolioImages;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Default controller for the `portfolio` module
 */
class DefaultController extends ModuleController
{

    private $uploader;

    public function __construct($id, $module, UploadInterface $uploader, $config = [])
    {
        $this->uploader = $uploader;
        parent::__construct($id, $module, $config);
    }

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(),[
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['upload', 'loaded', 'delete-image', 'edit-image', 'update-positions-images'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'upload' => ['post'],
                    'loaded' => ['post'],
                    'delete-image' => ['post'],
                    'edit-image' => ['post'],
                    'update-positions-images' => ['post'],
                ],
            ],
        ]);
    }

    public function actionIndex()
    {
        $model = new Portfolio();
        return $this->render('index',[
            'dataProvider' => $this->findData($model::find()->orderBy('pos'))
        ]);
    }

    /**
     * @param $id
     * @return bool
     */
    public function actionUpload($id)
    {
        $path = Yii::getAlias('@frontend/web'.Portfolio::GALLERY_SAVE_PATH . $id . '/');
        if($image = $this->uploader->upload($id, $path, 'Portfolio[filesGallery]'))
        {
            $newImage = new PortfolioImages();
            $newImage->name = $image['name'];
            $newImage->ext = $image['ext'];
            if($id){
                $newImage->portfolio_id = $id;
            }
            return $newImage->save();
        }
        return false;
    }

    public function actionDeleteImage($id)
    {
        $model = PortfolioImages::findOne($id);
        return $model->delete();
    }

    public function actionLoaded($id)
    {
        return $this->renderAjax('_images_box', [
            'model' => Portfolio::find()->where(['id' => $id])->with(['portfolioImages'])->one()
        ]);
    }

    public function actionUpdatePos()
    {
        $toDb = Yii::$app->request->post('positions');
        if($toDb){
            foreach($toDb as $id => $pos){
                if($hc = Portfolio::findOne((int)$id)){
                    $hc->pos = $pos;
                    $hc->update();
                }
            }
        }
        return $this->redirect(Yii::$app->homeUrl . $this->module->id);
    }

    public function actionEditImage($id)
    {
        $model = PortfolioImages::findOne($id);
        if($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()){
            return Json::encode($this->renderAjax('_images_box', ['model' => Portfolio::find()->where(['id' => $model['portfolio_id']])->with(['portfolioImages'])->one()]));
        }
        return $this->renderAjax('_image_edit', ['model' => $model]);
    }

    public function actionUpdatePositionsImages($id)
    {
        if($data = Yii::$app->request->post('data')){
            foreach($data as $pos => $id){
                if($image = PortfolioImages::findOne((int)$id)){
                    $image->pos = $pos;
                    $image->update();
                }
            }
        }
        return true;
    }

}
