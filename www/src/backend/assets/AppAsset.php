<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'static/css/fonts.css',
        'static/fonts/icons/style.css',
        'static/css/reset.css',
        'static/css/variables.css',
        'static/css/animations.css',
        'static/css/select2.css',
        'static/css/style.css',
        'static/css/auth.css',
        'static/css/crud_index.css',
        'static/css/crud_update.css',
        'static/css/header.css',
        'static/css/modal.css',
        'static/css/sidebar.css',
        'static/css/user.css',
    ];
    public $js = [
        'static/js/api.js',
        'static/js/modal.js',
        'static/js/fileupload.js',
        'static/js/app.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
