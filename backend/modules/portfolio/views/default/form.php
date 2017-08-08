<?php
/* @var $this yii\web\View */
/* @var $model common\models\Portfolio */

use backend\assets\FileUploaderAsset;
use backend\assets\GalleryAsset;
use backend\assets\SingleEditorAsset;
use backend\assets\DnDAsset;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

DnDAsset::register($this);
SingleEditorAsset::register($this);
FileUploaderAsset::register($this);
GalleryAsset::register($this);

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
                        <?php if(!$model->isNewRecord):?>
                        <li><a href="#image" data-toggle="tab">Галерея</a></li>
                        <?php endif;?>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="main">
                            <div class="row">
                                <div class="col-md-12">
                                    <?= $form->field($model, 'name')->textInput(['autocomplete' => 'off']) ?>
                                    <?= $form->field($model, 'domain')->textInput(['autocomplete' => 'off']) ?>
                                    <?= $form->field($model, 'description')->textarea([
                                        'id' => 'editor-full',
                                        'placeholder' => 'Введите текст...'
                                    ]) ?>
                                </div>
                            </div>

                            <?= $this->render('@backend/views/blocks/actions_panel')?>

                        </div>
                        <div class="tab-pane" id="image">
                            <div class="row">
                                <div class="col-md-12">
                                    <?= $form->field($model, 'filesGallery')->fileInput([
                                        'multiple' => 'multiple',
                                        'class' => 'file-input-ajax'
                                    ])->label(false) ?>
                                </div>
                            </div>
                            <div class="row" id="_images_box">
                                <?= $this->render('_images_box',[
                                    'model' => $model
                                ])?>
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
<?= Html::tag('div','',['class' => 'modal fade', 'id' => 'edit-image'])?>