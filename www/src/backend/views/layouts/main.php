<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Url;
use common\models\LoginForm;
use yii\helpers\Html;
backend\assets\AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<?php if (!Yii::$app->user->isGuest) { ?>
    <div class="wrapper">
        <div class="wrapper-content">
            <div class="sidebar">
                <?= $this->render('_sidebar.php') ?>
            </div>
            <div class="header">
                <?= $this->render('_header.php') ?>
            </div>
            <div class="content">
                <?= $content ?>
            </div>
        </div>
    </div>
<?php } else { ?>
    <?= $content ?>
<?php } ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
