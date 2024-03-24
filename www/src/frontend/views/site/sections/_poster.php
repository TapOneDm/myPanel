<?php

?>

<div class="container block">
    <div class="poster">
        <div class="poster-img">
            <img src="/static/img/banner.jpg" alt="">
            <div class="poster-img-info">
                <div class="poster-img-info-label">Since 1996</div>
                <h2 class="poster-img-info-text">True. Fontanka.<br>Underground.</h2>
            </div>
        </div>
        <div class="poster-tabs tabs">
            <div class="tabs-nav">
                <button class="tabs-nav-bnt active" type="button" data-tab="#tab1">Ближайшие</button>
                <button class="tabs-nav-bnt" type="button" data-tab="#tab2">Скоро</button>
            </div>
            <div class="tabs-content">
                <div id="tab1" class="tabs-item active">
                    <div class="poster-tab-content-cards">
                        <?php for ($i = 1; $i < 5; $i++) { ?>
                            <a href="#" class="content-card">
                                <img src="<?= "/static/img/tabs/$i.jpg" ?>" alt="">
                            </a>
                        <?php } ?>
                    </div>
                </div>
                <div id="tab2" class="tabs-item">
                    <div class="poster-tab-content-cards">
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