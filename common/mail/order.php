<?php

/* @var $this yii\web\View */
/* @var $model frontend\models\OrderForm */

?>
<div class="order">
    <p>Услуга: <?= $model->service?></p>
    <p>Номер телефона: <?= $model->phone?></p>
    <p>Email: <?= $model->email?></p>
    <p>Ваше имя: <?= $model->fio?></p>
    <?php if($model->info):?>
    <p>Дополнительная информация: <?= $model->info?></p>
    <?php endif;?>
</div>