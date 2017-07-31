<?php
/* @var $this yii\web\View */
/* @var $model common\models\SliderTextItems */
/* @var $slider_text common\models\SliderText */

use backend\assets\SingleEditorAsset;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

SingleEditorAsset::register($this);

$this->params['breadcrumbs'][] = ['label' => $this->context->module->params['name'], 'url' => Url::toRoute(['/'.$this->context->module->id])];
$this->params['breadcrumbs'][] = ['label' => $slider_text['name'], 'url' => Url::previous()];
$this->params['breadcrumbs'][] = $this->context->actions[$this->context->action->id];
?>
<div class="row">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin(['method' => 'post', 'options' => ['enctype' => 'multipart/form-data']]); ?>

        <div class="panel panel-flat">

            <div class="panel-body">

                <div class="row">
                    <div class="col-md-12">
                        <?= $form->field($model, 'text')->textarea([
                            'id' => 'editor-full',
                            'placeholder' => 'Введите текст...'
                        ]) ?>
                        <?php if($model->isNewRecord):?>
                            <?= $form->field($model, 'slider_text_id')->hiddenInput(['value' => $slider_text['id']])->label(false) ?>
                        <?php endif;?>
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