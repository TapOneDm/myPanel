<?php
use \yii\widgets\ListView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$blogs = $dataProvider->getModels();
?>

<h1>Блоги</h1>
<br>

<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_one'
]);
?>

