<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $dataProvider common\models\Services */
/* @var $this yii\web\View */

$this->params['breadcrumbs'][] = $this->context->module->params['name'];?>
    <?= Html::beginForm(['/'.$this->context->module->id.'/update-pos'], 'post', ['class' => 'with__positions']) ?>
        <?php echo GridView::widget([
            'dataProvider' => $dataProvider,
            'summary' => false,
            'tableOptions' => ['class' => 'table responsive'],
            'showFooter' => true,
            'columns' => [
                'name',
                [
                    'header' => 'Иконка',
                    'value' => function ($model) {
                        return Html::img($model::PATH.$model['image'], ['class' => 'icon_small']);
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
                        'update' => function($url){
                            return Html::a(Html::tag('i','',['class' => 'icon-pencil']), $url);
                        },
                        'delete' => function($url){
                            return Html::a(Html::tag('i','',['class' => 'icon-trash']), $url);
                        }
                    ],
                ],
            ],
        ]);?>
    <?= Html::endForm() ?>
<?php echo Html::tag('div', Html::a('Добавить' . Html::tag('i','',['class' => 'icon-add position-right']), Url::toRoute(["/{$this->context->module->id}/add"]), [
    'class' => 'btn bg-blue white'
]));?>
