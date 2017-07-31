<?php
/* @var $this yii\web\View */
/* @var $model common\models\Pages */

use backend\assets\SingleEditorAsset;
use backend\assets\SelectAsset;
use common\models\SliderText;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

SingleEditorAsset::register($this);
SelectAsset::register($this);

$this->params['breadcrumbs'][] = ['label' => $this->context->module->params['name'], 'url' => Url::toRoute(['/'.$this->context->module->id])];
$this->params['breadcrumbs'][] = $this->context->actions[$this->context->action->id];
?>
<div class="row">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin(['method' => 'post', 'options' => ['enctype' => 'multipart/form-data']]); ?>

        <div class="panel panel-flat">

            <div class="panel-body">

                <div class="tabbable">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#main" data-toggle="tab">Основное</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="main">
                            <div class="row">
                                <div class="col-md-12">
                                    <?= $form->field($model, 'slider_text_id')->dropDownList(
                                            ArrayHelper::map(SliderText::find()->asArray()->all(),'id','name'),
                                            [
                                                'prompt' => 'Не выбрано',
                                                'class' => 'select-search', 'data-width' => '100%'
                                            ]
                                    )?>
                                    <?= $form->field($model, 'name')->textInput(['autocomplete' => 'off']) ?>
                                    <?= $form->field($model, 'title')->textInput(['autocomplete' => 'off']) ?>
                                    <?= $form->field($model, 'description')->textInput(['autocomplete' => 'off']) ?>
                                    <?= $form->field($model, 'alias')->textInput(['autocomplete' => 'off']) ?>
                                    <?= $form->field($model, 'text')->textarea([
                                        'id' => 'editor-full',
                                        'placeholder' => 'Введите текст...'
                                    ]) ?>
                                </div>
                            </div>

                            <?= $this->render('@backend/views/blocks/actions_panel')?>

                        </div>

                    </div>
                </div>

            </div>

        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>