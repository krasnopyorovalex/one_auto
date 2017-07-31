<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap.min.css',
        'css/app.min.css',
    ];
    public $js = [
        'js/bootstrap.min.js',
        'js/app.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset'
    ];
}
