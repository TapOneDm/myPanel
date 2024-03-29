<?php

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../../src/vendor/autoload.php';
require __DIR__ . '/../../src/vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/../../src/common/config/bootstrap.php';
require __DIR__ . '/../../src/backend/config/bootstrap.php';

$config = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../../src/common/config/main.php',
    require __DIR__ . '/../../src/backend/config/main.php',
);

(new yii\web\Application($config))->run();
