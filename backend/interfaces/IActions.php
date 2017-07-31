<?php

namespace backend\interfaces;

interface IActions
{
    public function actionIndex();

    public function actionAdd();

    public function actionUpdate($id);

    public function actionDelete($id);

}