<?php
/* @var $this yii\web\View */
/* @var $model common\models\ProductsOld */
/* @var $catalog common\models\Catalog */
/* @var $category common\models\Category*/
/* @var $subcategory common\models\SubCategory*/
/* @var $options common\models\ProductsOptions*/
/* @var $productOptions common\models\ProductsOptionsVia*/
/* @var array $autoModels common\models\AutoModels*/

use backend\assets\SingleEditorAsset;
use backend\assets\SelectAsset;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

SingleEditorAsset::register($this);
SelectAsset::register($this);

$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => Url::toRoute(['/catalog'])];
$this->params['breadcrumbs'][] = ['label' => $catalog->name, 'url' => Url::toRoute(['/catalog/categories/'.$catalog->id])];
$this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => Url::toRoute(['/category/sub-categories/'.$category->id])];
$this->params['breadcrumbs'][] = ['label' => $subcategory->name, 'url' => Url::toRoute(['/subcategory/products/'.$subcategory->id])];
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
                        <li><a href="#image" data-toggle="tab">Изображение</a></li>
                        <li><a href="#options" data-toggle="tab">Атрибуты</a></li>
                        <li><a href="#auto_brands" data-toggle="tab">Привязка запчасти к модели авто</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="main">
                            <div class="row">
                                <div class="col-md-9">
                                    <?= $form->field($model, 'name')->textInput(['autocomplete' => 'off', 'id' => 'from__generate']) ?>
                                    <?= $form->field($model, 'alias', [
                                        'template' => '<div class="form-group">{label}<div class="input-group"><span class="input-group-addon"><i class="icon-pencil"></i></span>{input}{error}{hint}</div></div>'
                                    ])->textInput([
                                        'autocomplete' => 'off',
                                        'class' => 'form-control',
                                        'id' => 'to__generate'
                                    ]) ?>
                                    <?= $form->field($model, 'maker')->textInput(['autocomplete' => 'off']) ?>
                                    <?php if($model->isNewRecord):?>
                                        <?= Html::activeInput('hidden',$model,'subcategory_id',['value' => $subcategory->id])?>
                                    <?php endif;?>
                                </div>
                                <div class="col-md-3">
                                    <?= $form->field($model, 'price')->textInput(['autocomplete' => 'off']) ?>
                                    <?= $form->field($model, 'articul')->textInput(['autocomplete' => 'off']) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <?= $form->field($model, 'text')->textarea([
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
                                    <?php if($model->image):?>
                                        <div class="thumbnail-single">
                                            <?= Html::img($model::PATH.$model->image)?>
                                            <?= Html::button(Html::tag('b','', ['class' => 'icon-trash']) . 'Удалить',[
                                                'class' => 'btn btn-danger btn-labeled btn-sm remove_image'
                                            ])?>
                                        </div><hr>
                                    <?php endif;?>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <?= $form->field($model, 'file')->fileInput(['accept' => 'image/*']) ?>
                                </div>
                            </div>

                            <?= $this->render('@backend/views/blocks/actions_panel')?>

                        </div>

                        <div class="tab-pane" id="options">
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- product options -->
                                    <?php if($options):?>
                                        <?= Html::beginTag('div', ['class' => 'product_options'])?>
                                        <?php foreach ($options as $o):?>
                                            <?= $form->field($model, 'options['.$o['id'].']')->textInput([
                                                'value' => isset($productOptions[$o['id']])
                                                    ? $productOptions[$o['id']]
                                                    : ''
                                            ])->label($o['name'])?>
                                        <?php endforeach;?>
                                        <?= Html::endTag('div')?>
                                    <?php endif;?>
                                    <!-- product options -->
                                </div>
                            </div>

                            <?= $this->render('@backend/views/blocks/actions_panel')?>

                        </div>
                        <div class="tab-pane" id="auto_brands">
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- product auto brands -->
                                        <?= $form->field($model,'autoModelsValues')->dropDownList($autoModels,[
                                                'multiple' => 'multiple',
                                                'class' => 'select'
                                        ])?>
                                    <!-- product auto brands -->
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