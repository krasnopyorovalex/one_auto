<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>Административная панель - ООО «Красбер»</title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<?= $this->render('@app/views/blocks/main_nav')?>

<!-- Page container -->
<div class="page-container">

    <!-- Page content -->
    <div class="page-content">

        <!-- Main sidebar -->
        <div class="sidebar sidebar-main">
            <div class="sidebar-content">

                <!-- Main navigation -->
                <div class="sidebar-category sidebar-category-visible">
                    <div class="category-content no-padding">
                        <ul class="navigation navigation-main navigation-accordion">

                            <!-- Main -->
                            <li class="navigation-header"><span>Навигация</span> <i class="icon-menu" title="Навигация"></i></li>
                            <li><a href="<?= \yii\helpers\Url::toRoute(['/pages/default/index'])?>"><i class="icon-compose"></i> <span>Страницы</span></a></li>
                            <li><a href="<?= \yii\helpers\Url::toRoute(['/news/default/index'])?>"><i class="icon-newspaper"></i> <span>Новости</span></a></li>
                            <li><a href="<?= \yii\helpers\Url::toRoute(['/articles/default/index'])?>"><i class="icon-magazine"></i> <span>Статьи</span></a></li>
                            <li><a href="<?= \yii\helpers\Url::toRoute(['/landings/default/index'])?>"><i class="icon-wrench2"></i> <span>Лендосы</span></a></li>
                            <li><a href="<?= \yii\helpers\Url::toRoute(['/services/default/index'])?>"><i class="icon-list2"></i> <span>Услуги</span></a></li>
                            <li><a href="<?= \yii\helpers\Url::toRoute(['/sof_work/default/index'])?>"><i class="icon-stairs-up"></i> <span>Этапы работы</span></a></li>
                            <li><a href="<?= \yii\helpers\Url::toRoute(['/guestbook/default/index'])?>"><i class="icon-bubble2"></i> <span>Отзывы</span></a></li>
                            <li><a href="<?= \yii\helpers\Url::toRoute(['/slider_text/default/index'])?>"><i class="icon-file-text2"></i> <span>Слайдер-текст</span></a></li>
                            <li><a href="<?= \yii\helpers\Url::toRoute(['/portfolio/default/index'])?>"><i class="icon-images3"></i> <span>Портфолио</span></a></li>
                            <li><a href="<?= \yii\helpers\Url::toRoute(['/blocks/default/index'])?>"><i class="icon-grid7"></i> <span>Блоки сайта</span></a></li>
                            <li><a href="<?= \yii\helpers\Url::toRoute(['/menu/default/index'])?>"><i class="icon-lan2"></i> <span>Навигация</span></a></li>
                            <li><a href="<?= \yii\helpers\Url::toRoute(['/redirects/default/index'])?>"><i class="icon-transmission"></i> <span>Редиректы</span></a></li>

                        </ul>
                    </div>
                </div>
                <!-- /main navigation -->

                <div class="info_btn">
                    <button type="button" data-toggle="modal" data-target="#modal_info" class="btn btn-primary btn-labeled btn-xlg"><b><i class="icon-info3"></i></b> Информация</button>
                </div>

            </div>
        </div>
        <!-- /main sidebar -->


        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Page header -->
            <div class="page-header page-header-default">

                <div class="breadcrumb-line">
                    <?= Breadcrumbs::widget([
                        'itemTemplate' => '<li>{link}</li>',
                        'activeItemTemplate' => '<li class="active">{link}</li>',
                        'options' => ['class' => 'breadcrumb'],
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        'homeLink' => [
                            'label' => 'Домой',
                            'url' => Yii::$app->homeUrl,
                            'template' => '<li><i class="icon-home2 position-left"></i>{link}</li>',
                        ]
                    ]) ?>
                </div>
            </div>
            <!-- /page header -->


            <!-- Content area -->
            <div class="content">

                <!-- Dashboard content -->
                    <?= $content ?>
                <!-- /dashboard content -->

                <!-- Footer -->
                <div class="footer text-muted">
                    &copy; ООО «Красбер» <?= date('Y')?>
                </div>
                <!-- /footer -->

            </div>
            <!-- /content area -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

</div>
<!-- /page container -->

<!-- Basic modal -->
<div id="modal_info" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Применение shortcode'ов</h5>
            </div>

            <div class="modal-body">
                <h6 class="text-semibold">Доступные shortcode'ы:</h6>
                <ul>
                    <li>Услуги - {services}</li>
                    <li>Портфолио - {portfolio}</li>
<!--                    <li>Продукты - {products}</li>-->
                    <li>Блок новостей-статей - {news_articles_list}</li>
                    <li>Новости - {news_list}</li>
                    <li>Статьи - {articles_list}</li>
                    <li>Лендосы - {landings_list}</li>
                    <li>Карта сайта - {sitemap}</li>
                    <li>Гостевая книга - {guestbook}</li>
                    <li>Блоки сайта - {block_1}, где цифра id блока. Блоки обязательно обернуть div'ом c классом - center</li>
                    <li>Ссылки в контенте - &lt;a href="/alias"&gt;Портфолио&lt;/a&gt;</li>
                    <li>Разделитель горизонтальный - &lt;div class="delimiter"&gt;&nbsp;&lt;/div&gt;</li>
                </ul>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn bg-primary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
<!-- /basic modal -->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
