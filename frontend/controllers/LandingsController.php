<?php

namespace frontend\controllers;

use common\models\Landings;
use yii\web\NotFoundHttpException;

/**
 * Landings Controller
 */
class LandingsController extends SiteController
{
    public $layout = false;

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionShow($id)
    {
        if(!$model = Landings::findOne($id)){
            throw new NotFoundHttpException();
        }
        return $this->renderFile('@frontend/web/userfiles/landings_tpl/'.$id.'/index.html',[
            'id' => $id
        ]);
    }
}
