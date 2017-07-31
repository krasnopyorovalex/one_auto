<?php
/* @var $this yii\web\View */
/* @var $model common\models\Products */

use backend\assets\SingleEditorAsset;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

SingleEditorAsset::register($this);

$this->params['breadcrumbs'][] = ['label' => $this->context->module->params['name'], 'url' => Url::toRoute(['/'.$this->context->module->id])];
$this->params['breadcrumbs'][] = $this->context->actions[$this->context->action->id];
?>
<div class="row">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin(['method' => 'post', 'options' => ['enctype' => 'multipart/form-data']]); ?>

        <div class="panel panel-flat">

            <div class="panel-body">

                <div class="row">
                    <div class="col-md-12">
                        <?= $form->field($model, 'form_type')->dropDownList([
                                0 => 'Тип формы номер ноль',
                                1 => 'Тип формы номер адын',
                        ]) ?>
                        <?= $form->field($model, 'name') ?>
                        <?= $form->field($model, 'price') ?>
                        <?= $form->field($model, 'btn_text') ?>
                        <?= $form->field($model, 'description')->textarea([
                            'id' => 'editor-full',
                            'placeholder' => 'Введите текст...'
                        ]) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <?= $this->render('@backend/views/blocks/actions_panel')?>
                    </div>
                </div>

            </div>

        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>