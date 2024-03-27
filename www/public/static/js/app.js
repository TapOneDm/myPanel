$(document).ready(function() {
    toggleHeaderShadow()
    toggleHeaderNav();
    toggleTabs();
    initKitchenSlider();
    initAccordion();
    initKitchenModalCard()
    handleModal()
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

function initAccordion() {
    $('.accordion-btn').each(function(_, el) {
        $(el).on('click', function() {
            const btn = $(this);
            const content = $(this).next();
            
            if (content.css('maxHeight') !== '0px') {
                $('.accordion').find('.accordion-btn').each((_, el) => $(el).removeClass('active'))
                $('.accordion').find('.accordion-content').each((_, el) => $(el).css({'maxHeight': '0px'}))
            } else {
                $('.accordion').find('.accordion-btn').each((_, el) => $(el).removeClass('active'))
                $('.accordion').find('.accordion-content').each((_, el) => $(el).css({'maxHeight': '0px'}))

                content.css({'maxHeight': content.prop('scrollHeight') + 'px'});
                btn.addClass('active');
            }
        })
    })
}

function initKitchenModalCard() {
    $('.kitchen-slide').each((_, el) => {
        $(el).on('click', (e) => {
            e.preventDefault()
            $('.kitchen-modal').parent().fadeIn(300)
        })
    })
}
function handleModal() {
    $('.modal').each((_, el) => {
        $(el).on('click', (e) => {
            if ($(e.target).hasClass('modal-button-close')) {
                $(el).parent().fadeOut(300)
            }
        })
    })
}