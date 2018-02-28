<?php

namespace frontend\widgets\SidebarMenu;

use common\models\Catalog;
use yii\base\Widget;

class SidebarMenu extends Widget
{
    public $model = null;
    public $autoBrand = null;
    public $autoModel = null;

    public function run()
    {
        if( ! $this->model ) {
            $this->model = Catalog::find()->where(['parent_id' => null])->limit(1)->one();
        }

        $root = $this->getParent($this->model);

        return $this->render('sidebar_menu.twig', [
            'model' => $root,
            'autoBrand' => $this->autoBrand,
            'autoModel' => $this->autoModel
        ]);
    }

    /**
     * @param $model
     * @return mixed
     */
    private function getParent($model)
    {
        while ($model->parent)
        {
            return $this->getParent($model->parent);
        }
        return $model;
    }
}