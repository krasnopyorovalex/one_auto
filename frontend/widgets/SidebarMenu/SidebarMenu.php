<?php

namespace frontend\widgets\SidebarMenu;

use yii\base\Widget;

class SidebarMenu extends Widget
{
    public $model;

    public function run()
    {
        return $this->render('sidebar_menu.twig', [
            'model' => $this->model
        ]);
    }
}