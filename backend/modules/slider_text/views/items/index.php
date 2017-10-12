<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var $slider_text common\models\SliderText */
/* @var $dataProvider common\models\SliderTextItems */
/* @var $this yii\web\View */

$this->params['breadcrumbs'][] = ['label' => $this->context->module->params['name'], 'url' => Url::toRoute(['/slider_text'])];
$this->params['breadcrumbs'][] = $slider_text['name'];?>

    <?= Html::beginForm(['/'.$this->context->module->id.'/items/update-pos-items'], 'post', ['class' => 'with__positions']) ?>
        <?php echo GridView::widget([
            'dataProvider' => $dataProvider,
            //'summary' => false,
            'tableOptions' => ['class' => 'table responsive'],
            'showFooter' => true,
            'columns' => [
                [
                    'header' => 'Текст',
                    'value' => function ($model) {
                        return StringHelper::truncateWords(strip_tags($model['text']), 7);
                    },
                    'format' => 'raw'
                ],
                [
                    'header' => 'Позиция',
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{pos}',
                    'buttons' => [
                        'pos' => function($url,$model){
                            return Html::input('text','positions['.$model['id'].']',$model['pos'],['autocomplete' => 'off']);
                        }
                    ],
                    'footer' => Html::submitButton('Сохранить',['class' => 'btn bg-teal btn-xs']),
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'Действия',
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function($url, $item){
                            return Html::a(Html::tag('i','',['class' => 'icon-pencil']),  Url::toRoute(['edit-item','id' => $item['id']]));
                        },
                        'delete' => function($url, $item){
                            return Html::a(Html::tag('i','',['class' => 'icon-trash']), Url::toRoute(['delete-item','id' => $item['id']]));
                        }
                    ],
                ],
            ],
        ]);?>
    <?= Html::endForm() ?>
    <?php echo Html::tag('div', Html::a('Добавить' . Html::tag('i','',['class' => 'icon-add position-right']), Url::toRoute(["/slider_text/items/add-item", 'id' => $slider_text['id']]), [
        'class' => 'btn bg-blue white'
    ]));?>
