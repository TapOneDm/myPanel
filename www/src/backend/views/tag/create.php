<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Tag $model */

$this->title = 'Create Tag';
$this->params['breadcrumbs'][] = ['label' => 'Tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-create crud-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
