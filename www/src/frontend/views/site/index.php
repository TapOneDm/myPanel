<?php

/**
 * @var yii\web\View $this
 */
?>

<div class="container">
    <div class="banner">
        <div class="banner-img">
            <img src="/static/img/banner.jpg" alt="">
            <div class="banner-img-info">
                <div class="banner-img-info-label">Since 1996</div>
                <h2 class="banner-img-info-text">True. Fontanka.<br>Underground.</h2>
            </div>
        </div>
        <div class="banner-tabs tabs">
            <div class="tabs-nav">
                <button class="tabs-nav-bnt active" type="button" data-tab="#tab1">Ближайшие</button>
                <button class="tabs-nav-bnt" type="button" data-tab="#tab2">Скоро</button>
            </div>
            <div class="tabs-content">
                <div id="tab1" class="tabs-item active">
                    <div class="banner-tab-content-cards">
                        <?php for ($i = 1; $i < 5; $i++) { ?>
                            <a href="#" class="content-card">
                                <img src="<?= "/static/img/tabs/$i.jpg" ?>" alt="">
                            </a>
                        <?php } ?>
                    </div>
                </div>
                <div id="tab2" class="tabs-item">
                    <div class="banner-tab-content-cards">
                        <?php for ($i = 4; $i > 0; $i--) { ?>
                            <a href="#" class="content-card">
                                <img src="<?= "/static/img/tabs/$i.jpg" ?>" alt="">
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>