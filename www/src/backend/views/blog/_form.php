<?php

use common\models\File;
use kartik\file\FileInput;
use kartik\select2\Select2;
use vova07\imperavi\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Blog $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="blog-form">
    <?php $form = ActiveForm::begin([
            'enableClientValidation' => true,
            'options' => [
                'enctype' => 'multipart/form-data',
                'autocomplete' => 'off'
            ],
    ]); ?>
    <div class="form-row">
        <?= Html::submitButton('Save', ['class' => 'save-btn']) ?>
    </div>
    <div class="form-row">
        <div class="form-col">
            <div class="form-image">
                <div
                    class="preview"
                    data-model_id="<?= $model->id ?>"
                    data-model_table="<?= \common\models\Blog::tableName() ?>"
                    data-file_field="<?= 'image' ?>"
                >
                    <div class="loader"><span></span></div>
                    <img src="<?= File::getUrl($model->image, 'blog') ?>" alt="">
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
            <div class="form-row">
                <?= $form->field($model, 'title')->textInput() ?>
                <?= $form->field($model, 'url')->textInput() ?>
            </div>

            <?php var_dump($model->related_tags) ?>
            <div class="form-row">
                <?= $form->field($model, 'related_tags')->widget(Select2::class, [
                'value' => $model->tags,
                'data' => \yii\helpers\ArrayHelper::map(\common\models\Tag::find()->all(), 'id', 'name'),
                'language' => 'ru',
                'options' => ['placeholder' => 'Select tags ...'],
                'pluginOptions' => [
                    'multiple' => true,
                    'maximumInputLength'=> 100,
                    'allowClear' => true,
                    'tags' => false,
                        ],
                ]) ?>
            </div>

            <div class="form-row">
                <?= $form->field($model, 'text')->widget(Widget::class, [
                    'settings' => [
                        'lang' => 'ru',
                        'minHeight' => 200,
                        'imageUpload' => \yii\helpers\Url::to(['site/save-wysiwyg-image']),
                        'plugins' => [
                            'clips',
                            'fullscreen',
                        ],
                        'clips' => [
                            ['Lorem ipsum...', 'Lorem...'],
                            ['red', '<span class="label-red">red</span>'],
                            ['green', '<span class="label-green">green</span>'],
                            ['blue', '<span class="label-blue">blue</span>'],
                        ],
                    ],
                ]); ?>
            </div>
            <div class="form-row">
                <?= $form->field($model, 'status_id')->textInput() ?>
                <?= $form->field($model, 'user_id')->textInput() ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
