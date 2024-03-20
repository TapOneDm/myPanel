<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
/**
 * Site controller
 */
class SiteController extends Controller
{

    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
}
