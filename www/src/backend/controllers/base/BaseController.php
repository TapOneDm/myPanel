<?php

namespace backend\controllers\base;

use Yii;
use yii\web\Controller;

class BaseController extends Controller
{
    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest && Yii::$app->controller->action->id != "login") {
            $this->redirect('../layouts/auth');
            Yii::$app->user->loginRequired();
        }
        return true;
    }

}