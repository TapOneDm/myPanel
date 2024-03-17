<?php
/* @var $this yii\web\View */
/* @var $model */

use yii\helpers\Html;

?>

<h1><?= $model->title ?></h1>
<div><?= $model->text ?></div>
<span><?= $model->author->email ?></span>
<div><?= Html::a('подробнее', "blog/$model->url", ['class' => 'btn btn-success']) ?></div>