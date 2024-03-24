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
        'static/vendor/tiny-slider/tiny-slider.css',
        'static/css/variables.css',
        'static/css/fonts.css',
        'static/fonts/icons/style.css',
        'static/css/reset.css',
        'static/css/base.css',
        'static/css/style.css',
        'static/css/media.css',
    ];
    public $js = [
        'static/vendor/tiny-slider/tiny-slider.js',
        'static/js/app.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
