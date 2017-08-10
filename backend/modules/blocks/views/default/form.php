<?php
/* @var $this yii\web\View */
/* @var $model common\models\Blocks */

use backend\assets\SelectAsset;
use backend\assets\SingleEditorAsset;
use backend\assets\AddEditorAsset;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;


SingleEditorAsset::register($this);
AddEditorAsset::register($this);
SelectAsset::register($this);

$this->params['breadcrumbs'][] = ['label' => $this->context->module->params['name'], 'url' => Url::toRoute(['/'.$this->context->module->id])];
$this->params['breadcrumbs'][] = $this->context->actions[$this->context->action->id];
?>
<div class="row">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin(['method' => 'post', 'options' => ['enctype' => 'multipart/form-data']]); ?>

        <div class="panel panel-flat">

            <div class="panel-body">

                <?= $form->field($model, 'color')->dropDownList([
                    'blue' => 'Синий',
                    'green' => 'Зелёный',
                    'cherry' => 'Вишневый',
                    'yellow' => 'Желтый'
                ],[
                    'class' => 'select-search', 'data-width' => '100%'
                ]) ?>

                <?= $form->field($model, 'name')->textInput(['autocomplete' => 'off']) ?>
                <?= $form->field($model, 'btn_text')->textInput(['autocomplete' => 'off']) ?>
                <?= $form->field($model, 'price')->textarea([
                    'id' => 'editor-full-add',
                    'placeholder' => 'Введите текст...'
                ]) ?>
                <?= $form->field($model, 'description')->textarea([
                    'id' => 'editor-full',
                    'placeholder' => 'Введите текст...'
                ]) ?>
                <?= $this->render('@backend/views/blocks/actions_panel')?>

            </div>

        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>