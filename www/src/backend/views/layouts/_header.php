<?php

use common\models\File;

$user = \common\models\User::findOne(Yii::$app->user->getId());

?>

<div class="header-content">
    <div class="header-left">
        <div class="header-logo">
            <img src="/static/img/logo.svg" alt="">
        </div>
        <div class="header-button-toggle">
            <span></span>
        </div>
    </div>
    <div class="header-greetings">
        <div><?= date("M. d. Y") ?></div>
    </div>
    <div class="header-items">

    <a class="notifications"><i class="icon-bell"></i></a>
        <a href="<?= \yii\helpers\Url::to(['user/update?id=19']) ?>">
            <div class="login-user">
                <div class="user-image"><img src="<?= File::getThumb($user->image, 'user', '50x50') ?>" alt=""></div>
                <div class="user-name"><?= $user->username ?></div>
            </div>
        </a>
        <?= \yii\helpers\Html::a('<i class="icon-portal-exit"></i>', \yii\helpers\Url::to(['site/logout'])) ?>
    </div>
</div>