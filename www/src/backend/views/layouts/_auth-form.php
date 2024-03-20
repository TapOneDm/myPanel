<?php

/* @var LoginForm $model */

use common\models\LoginForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin([
    'enableClientValidation' => false,
    'options' => [
        'data-pjax' => true,
    ],
]) ?>

<div class="form-col">
    <div class="form-row no-gap">
        <?= $form->field($model, 'username')
            ->label(false)
            ->textInput(
                [
                    'autocomplete' => 'off',
                    'placeholder' => $model->getAttributeLabel(
                        'username',
                        [
                            'class' => Yii::$app->session->getFlash('LOGIN_FAILED') ? 'auth-failed' : null
                        ]
                    )
                ]
            ) ?>
        <div class="icon-box">
            <i class="icon-user"></i>
        </div>
    </div>

    <div class="form-row no-gap">
        <?= $form->field($model, 'password')
            ->label(false)
            ->passwordInput([
                'placeholder' => $model->getAttributeLabel('password'),
                'class' => Yii::$app->session->getFlash('LOGIN_FAILED') ? 'auth-failed' : null

            ]) ?>
        <div class="icon-box">
            <i class="icon-lock-alt"></i>
        </div>
    </div>
    <?= Html::submitButton('Login') ?>
</div>

<div class="form-row">
    <?= $form->field($model, 'rememberMe')->checkbox([
        'template' => '<div class="icheck-primary">{input}{label}</div>',
        'labelOptions' => [
            'class' => 'rememberme'
        ],
        'uncheck' => null
    ]) ?>
    <div class="auth-forgot-password">
        <a href="#">Forgot password</a>
    </div>
</div>

<?php ActiveForm::end(); ?>