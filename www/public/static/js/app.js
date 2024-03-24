$(document).ready(function() {
    toggleHeaderShadow()
    toggleHeaderNav();
    toggleTabs();
    initKitchenSlider();
})

function toggleHeaderShadow() {
    $(window).scroll(function() {
        let scroll = $(window).scrollTop();
        if (scroll > 0) {
            $("header").addClass("active");
        }
        else {
            $("header").removeClass("active");
        }
    });
}

function toggleHeaderNav() {
    $('.toggle-menu').on('click', function() {
        $('.header-inner .nav').toggleClass('active');
        $('.open-layout').toggleClass('active');
    })
}

function toggleTabs() {
    const tabsNavBtn = $('.tabs-nav-bnt');
    const tabsItems = $('.tabs-item')

    tabsNavBtn.each(function(_, button) {
        $(button).on('click', function() {
            let currentBtn = $(this);
            let tabId = currentBtn.data('tab');
            let currentTab = $(`.tabs-content ${tabId}`)

            tabsNavBtn.each(function(_, button) {
                $(button).removeClass('active');
            })

            tabsItems.each(function(_, tab) {
                $(tab).removeClass('active');
            })

            currentBtn.addClass('active', !currentBtn.hasClass('active'));
            currentTab.addClass('active', !currentTab.hasClass('active'))
        })
    })
}

function initKitchenSlider() {
    let slider = $('.kitchen-slider'); 
    if (slider) {
        tns({
            container: slider[0],
            items: 1,
            slideBy: 'page',
            autoplay: false,
            lazyload: true,
            autoplayButtonOutput: false,
            controls: true,
            mouseDrag: true,
            controlsContainer: "#kitchen-slider-controls",
            responsive: {
                991: {
                    items: 2
                },
            }
        });
    }
}