<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\File;

/** @var yii\web\View $this */
/** @var common\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form">
    <?php $form = ActiveForm::begin(
        [
            'enableClientValidation' => true,
            'options' => [
                'enctype' => 'multipart/form-data',
                'autocomplete' => 'off',
            ]
        ]
        ); ?>
    <div class="form-row">
        <div class="form-notification-line">
            <?= Html::submitButton('Save', ['class' => 'save-btn']) ?>
        </div>
    </div>
    <div class="form-row">
        <div class="form-col">
            <div class="form-image">
                <div
                    class="preview"
                    data-model_id="<?= $model->id ?>"
                    data-model_table="<?= \common\models\User::tableName() ?>"
                    data-file_field="<?= 'image' ?>"
                >
                    <div class="loader"><span></span></div>
                    <img src="<?= File::getUrl($model->image, 'user') ?>" alt="">
                    <div class="preview-placeholder">
                        <i class="icon-file-image"></i>
                        Upload image
                    </div>
                    <div class="form-image-actions">
                        <div class="action-delete">
                            <i class="icon-trash"></i>
                        </div>
                    </div>
                </div>
                <?= $form->field($model, 'file')->fileInput()->label(false) ?>
                <?php $this->registerJs('new File(".form-image", {})');?>
            </div>
        </div>

        <div class="form-col">
            <?= $form->field($model, 'username')->textInput() ?>
            <?= $form->field($model, 'email')->textInput() ?>
            <?= $form->field($model, 'permissions')->widget(Select2::class, [
                'data' => $model->permissionsList,
                'language' => 'ru',
                'options' => [
                    'placeholder' => 'Select access roles ...',
                    'value' => $model->userPermissions
                ],
                'pluginOptions' => [
                    'multiple' => true,
                    'maximumInputLength'=> 100,
                    'allowClear' => true,
                    'tags' => false,
                ],
            ]) ?>

            <?php if ($this->context->action->id === 'create' || (isset($model->id) && Yii::$app->user->getId() === $model->id)) {?>
                <?= $form->field($model, 'passwd')->passwordInput() ?>
            <?php } ?>
        <div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
