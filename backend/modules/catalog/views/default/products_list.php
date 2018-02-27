<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $dataProvider common\models\Products */
/* @var $category common\models\Catalog */
/* @var $this yii\web\View */

if(isset($category->parent->parent->parent)){
    $this->params['breadcrumbs'][] = ['label' => $category->parent->parent->parent->name, 'url' => Url::toRoute(['/catalog'])];
}

if($category->parent->parent){
    $this->params['breadcrumbs'][] = ['label' => $category->parent->parent->name, 'url' => Url::toRoute(['/catalog'])];
}

if($category->parent){
    $this->params['breadcrumbs'][] = ['label' => $category->parent->name, 'url' => Url::toRoute(['/catalog'])];
}

$this->params['breadcrumbs'][] = $category->name;

?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'tableOptions' => ['class' => 'table responsive'],
    'columns' => [
        'name',
        'alias',
        [
            'header' => 'Обновлен',
            'value' => function ($model) {
                return Yii::$app->formatter->asDate($model->updated_at);
            },
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Действия',
            'template' => '{update} {products} {delete}',
            'buttons' => [
                'update' => function($url){
                    return Html::a(Html::tag('i','',[
                        'class' => 'icon-pencil',
                        'data-popup' => 'tooltip',
                        'data-original-title' => 'Редактировать запись'
                    ]), str_replace('catalog','products',$url));
                },
                'delete' => function($url){
                    return Html::a(Html::tag('i','',[
                        'class' => 'icon-trash',
                        'data-popup' => 'tooltip',
                        'data-original-title' => 'Удалить запись'
                    ]), str_replace('catalog','products',$url));
                }
            ],
        ],
    ],
]);
echo Html::tag('div', Html::a('Добавить' . Html::tag('i','',['class' => 'icon-add position-right']), Url::toRoute(["/products/add/".$category->id]), [
    'class' => 'btn bg-blue white'
]));?>