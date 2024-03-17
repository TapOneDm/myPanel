<?php

/**
 * @var yii\web\View $this
 * @var $blogs
 */

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="p-5 mb-4 bg-transparent rounded-3">
        <div class="container-fluid py-5 text-center">
            <h1 class="display-4">Congratulations!</h1>
            <p class="fs-5 fw-light">You have successfully created your Yii-powered application.</p>
            <p><a class="btn btn-lg btn-success" href="https://www.yiiframework.com">Get started with Yii</a></p>
        </div>
    </div>

    <div class="body-content">

        <?php foreach ($blogs as $blog) {?>
            <div class="row">
                <h3><?= $blog->title ?></h3>
                <div><?= $blog->text ?></div>
            </div>
        <?php }?>

    </div>
</div>
