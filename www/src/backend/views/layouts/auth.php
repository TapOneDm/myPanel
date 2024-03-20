<?php
/* @var \yii\web\View $this */

use common\models\LoginForm;

?>

<div class="auth">
    <div class="auth-wrapper">
    <div class="auth-logo">
        <img src="/static/img/logo.svg" alt="">
    </div>            
    <div class="auth-form">
        <?php \yii\widgets\Pjax::begin(['id' => 'auth-form', 'enablePushState' => false]) ?>
            <?= $this->render('_auth-form', ['model' => new LoginForm()]) ?>
        <?php \yii\widgets\Pjax::end() ?>
        </div>

    </div>
</div>