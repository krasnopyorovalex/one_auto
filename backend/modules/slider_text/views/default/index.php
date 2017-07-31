<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $dataProvider common\models\SliderText */
/* @var $this yii\web\View */

$this->params['breadcrumbs'][] = $this->context->module->params['name'];?>
        <?php echo GridView::widget([
            'dataProvider' => $dataProvider,
            //'summary' => false,
            'tableOptions' => ['class' => 'table responsive'],
            'showFooter' => true,
            'columns' => [
                'name',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'Действия',
                    'template' => '{update} {items} {delete}',
                    'buttons' => [
                        'update' => function($url){
                            return Html::a(Html::tag('i','',['class' => 'icon-pencil']), $url);
                        },
                        'items' => function($url){
                            return Html::a(Html::tag('i','',['class' => 'icon-file-text']), $url, [
                                'data-original-title' => 'Список текстов',
                                'data-popup' => 'tooltip'
                            ]);
                        },
                        'delete' => function($url){
                            return Html::a(Html::tag('i','',['class' => 'icon-trash']), $url);
                        }
                    ],
                ],
            ],
        ]);?>
    <?php echo Html::tag('div', Html::a('Добавить' . Html::tag('i','',['class' => 'icon-add position-right']), Url::toRoute(["/{$this->context->module->id}/add"]), [
        'class' => 'btn bg-blue white'
    ]));?>
