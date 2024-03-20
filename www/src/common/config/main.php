<?php

$dbHost = env('POSTGRES_HOST');
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => 'pgsql:host=' . env('POSTGRES_HOST') . ';port=' . env('POSTGRES_PORT') . ';dbname=' . env('POSTGRES_DB_NAME'),
            'username' => env('POSTGRES_USER'),
            'password' => env('POSTGRES_PASSWORD'),
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@common/mail',
            'useFileTransport' => true,
        ],
        'request' => [
            'enableCookieValidation' => true,
            'enableCsrfValidation' => true,
            'cookieValidationKey' => env('COOKIE_VALIDATION_KEY'),
        ],
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'image' => [
            'class' => 'yii\image\ImageDriver',
            'driver' => 'Imagick',  //GD or Imagick
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            // uncomment if you want to cache RBAC items hierarchy
            // 'cache' => 'cache',
        ],
    ],
];
