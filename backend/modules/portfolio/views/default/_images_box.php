<?php

use yii\helpers\Html;

/* @var $model common\models\Portfolio */
?>
<?php if ($model->portfolioImages): ?>
    <ul class="nav nav-pills nav-justified" id="pills-target-right">
    <?php foreach ($model->portfolioImages as $image): ?>
        <li data-id="<?= $image->id?>">
            <div class="image-thumb">
                <div class="thumbnail">
                    <div class="thumb">
                        <?= Html::img('/userfiles/gallery/' . $model->id . '/' . $image->name . '_thumb.' . $image->ext)?>
                        <div class="caption-overflow">
                        <span>
                            <a class="btn btn-flat border-white text-white btn-rounded btn-icon" rel="group" data-popup="lightbox" href="/userfiles/gallery/<?= $model->id?>/<?= $image->name?>.<?= $image->ext?>">
                                <i class="icon-zoomin3"></i>
                            </a>
                            <a href="#" data-link="/_root/portfolio/edit-image/<?= $image->id?>" data-toggle="modal" data-target="#edit-image" class="btn btn-flat border-white text-white btn-rounded btn-icon">
                                <i class="icon-pencil"></i>
                            </a>
                            <a class="btn btn-flat border-white text-white btn-rounded btn-icon" href="/_root/<?= $this->context->module->id?>/delete-image/<?= $image->id?>">
                                <i class="icon-trash"></i>
                            </a>
                        </span>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>