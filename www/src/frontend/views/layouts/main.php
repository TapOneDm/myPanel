<?php

/** @var \yii\web\View $this */
/** @var string $content */

use frontend\assets\AppAsset;
use yii\bootstrap5\Html;

AppAsset::register($this);
$this->title = 'Manhattan - Club and Bar'
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>

    <div class="wrapper">
        <header>
            <div class="container">
                <div class="header-inner">
                    <a href="#" class="logo">
                        <img src="/static/img/logo.png" alt="">
                    </a>
                    <ul class=nav>
                        <li><a href="#">Главная</a></li>
                        <li><a href="#">Меню</a></li>
                        <li><a href="#">Афиша</a></li>
                        <li><a href="#">Сотрудничество</a></li>
                        <li><a href="#">Галерея</a></li>
                        <li><a href="#">Новости</a></li>
                        <li><a href="#" class="nav-reservation btn btn-outline">Бронирование</a></li>
                    </ul>
                    <div class="open-layout"></div>

                    <a href="#" class="reservation btn btn-outline">Бронирование</a>
                    <div class="toggle-menu">
                        <span></span>
                    </div>
                </div>
            </div>
        </header>

        <main>
            <?= $content ?>
        </main>

        <footer>Footer</footer>
    </div>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();
