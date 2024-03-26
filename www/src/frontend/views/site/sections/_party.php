<?php

$accordionItems = ['Loudspeakers', 'Amplifier', 'FOH', 'Backline', 'Microphone set', 'DJ equipment'];
?>

<div class="container block">
    <div class="block-title">
        <div class="block-title-label">Top “Manhattan” party</div>
        <h2 class="block-title-title">Техрайдер</h2>
    </div>

    <div class="party">
        <div class="party-accordion accordion">
            <?php foreach ($accordionItems as $item) { ?>
                <div class="accordion-btn">
                    <span><?= $item ?></span>
                    <i class="icon-angle-down"></i>
                </div>
                <ul class="accordion-content">
                    <li>Acoustic system BELL Top 600W x 2</li>
                    <li>Acoustic system BELL Mid 600W x 2</li>
                    <li>Acoustic system BELL Sub 1000W x 2</li>
                    <li>Front monitor Yamaha SM12V 300w x 2</li>
                    <li>Backside monitor Dynacord 500W x 2</li>
                </ul>
            <?php } ?>
        </div>
        <div class="party-people-guests">
            <div class="party-people-guests-title">Звукорежиссеры клуба МАНХЭТТЕН</div>
            <div class="party-people-guests-cards">
                <div class="party-people-guests-card">
                    <div class="party-people-guests-card-image">
                        <img src="/static/img/party/party_guest_1.jpg" alt="">
                    </div>
                    <div class="party-people-guests-card-name">Изотов Константин</div>
                    <div class="party-people-guests-card-social">
                        <div><i class="icon-globe"></i></div>
                        <div><i class="icon-globe"></i></div>
                    </div>
                </div>
                <div class="party-people-guests-card">
                    <div class="party-people-guests-card-image">
                        <img src="/static/img/party/party_guest_2.jpg" alt="">
                    </div>
                    <div class="party-people-guests-card-name">Давид Хозиев</div>
                    <div class="party-people-guests-card-social">
                        <div><i class="icon-globe"></i></div>
                        <div><i class="icon-globe"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>