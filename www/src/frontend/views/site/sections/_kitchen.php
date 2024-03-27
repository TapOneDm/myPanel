<?php

$slides = [1, 2, 3, 4, 5, 6];
?>

<div class="container block">
    <div class="block-title">
        <div class="block-title-label">Top “Manhattan” menu</div>
        <h2 class="block-title-title">Кухня</h2>
    </div>

    <div class="kitchen">
        <div id="kitchen-slider-controls">
            <div class="controls-prev" data-controls="prev">
                <i class="icon-angle-left"></i>
            </div>
            <div class="controls-next" data-controls="next">
                <i class="icon-angle-right"></i>
            </div>
        </div>
        <div class="kitchen-slider">
            <?php foreach ($slides as $slide) { ?>
                <div class="kitchen-slide kitchen-items">
                    <?php for ($i = 1; $i < 5; $i++) { ?>
                        <a href="#" class="kitchen-item">
                            <div class="kitchen-item-image">
                                <img src="/static/img/kitchen/kitchen-item_1.jpg" alt="">
                            </div>
                            <div class="kitchen-item-info">
                                <div class="kitchen-item-info-name">Amet donec.</div>
                                <div class="kitchen-item-info-portion">200 гр</div>
                                <div class="kitchen-item-info-description">Placerat id auctor nunc id vel vel curabitur. Urna fames maecenas leo elit diam nibh elit.</div>
                                <div class="kitchen-item-info-price">550 ₽</div>
                            </div>
                        </a>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
    <a href="#" class="kitchen-menu-button btn">Все меню</a>
</div>

<div class="modal-wrapper">
    <div class="modal kitchen-modal">
        <div class="modal-image">
            <img src="/static/img/kitchen/kitchen-item_1.jpg" alt="">
        </div>
        <div class="modal-info-title">Amet donec</div>
        <div class="modal-info-portion">200 гр</div>
        <div class="modal-info">
            <div class="modal-info-text">Placerat id auctor nunc id vel vel curabitur. Urna fames maecenas leo elit diam nibh elit. Placerat id auctor nunc id vel vel curabitur. Urna fames maecenas leo elit diam nibh elit. Placerat id auctor nunc id vel vel curabitur. Urna fames maecenas leo elit diam nibh elit. Placerat id auctor nunc id vel vel curabitur. Urna fames maecenas leo elit diam nibh elit. Placerat id auctor nunc id vel vel curabitur. Urna fames maecenas leo elit diam nibh elit. Placerat id auctor nunc id vel vel curabitur. Urna fames maecenas leo elit diam nibh elit. Placerat id auctor nunc id vel vel curabitur. Urna fames maecenas leo elit diam nibh elit. Placerat id auctor nunc id vel vel curabitur. Urna fames maecenas leo elit diam nibh elit.</div>
        </div>
        <div class="modal-button-close">Закрыть</div>
    </div>
</div>