(function ($) {

    "use strict";

    // Preloader
    function stylePreloader() {
        $('body').addClass('preloader-deactive');
    }

    // Background Image
    $('[data-bg-img]').each(function () {
        $(this).css('background-image', 'url(' + $(this).data("bg-img") + ')');
    });
    // Background Color
    $('[data-bg-color]').each(function () {
        $(this).css('background-color', $(this).data("bg-color"));
    });
    // Height
    $('[data-height]').each(function () {
        $(this).css('height', $(this).data("height"));
    });
    // Padding Bottom
    $('[data-padding-bottom]').each(function () {
        $(this).css('padding-bottom', $(this).data("padding-bottom"));
    });

    // Off Canvas JS
    var canvasWrapper = $(".off-canvas-wrapper");
    $(".btn-menu").on('click', function () {
        canvasWrapper.addClass('active');
        $("body").addClass('fix');
    });

    $(".close-action > .btn-close, .off-canvas-overlay").on('click', function () {
        canvasWrapper.removeClass('active');
        $("body").removeClass('fix');
    });

    //Responsive Slicknav JS
    $('.main-menu').slicknav({
        appendTo: '.res-mobile-menu',
        closeOnClick: true,
        removeClasses: true,
        closedSymbol: '<i class="icon-arrows-plus"></i>',
        openedSymbol: '<i class="icon-arrows-minus"></i>'
    });



    // Swipper JS
    $(document).ready(function () {
        var teamSlider = new Swiper('.team-slider-container', {
            slidesPerView: 4,
            speed: 500,
            loop: false,
            spaceBetween: 30,
            autoplay: true,
            pagination: {
                el: '.swiper-pagination-1',
                clickable: true
            },
            breakpoints: {
                1200: {
                    slidesPerView: 4
                },

                991: {
                    slidesPerView: 3
                },

                767: {
                    slidesPerView: 2

                },

                560: {
                    slidesPerView: 2
                },

                0: {
                    slidesPerView: 1
                }
            }
        });
        
        var caseSlider = new Swiper('.case-slider-container', {
            slidesPerView: 5,
            speed: 1000,
            loop: false,
            spaceBetween: 10,
            autoplay: false,
            pagination: {
                el: '.swiper-pagination',
                clickable: true
            },
            breakpoints: {
                1200: {
                    slidesPerView: 5,
                    slidesPerGroup: 5
                },

                991: {
                    slidesPerView: 4,
                    slidesPerGroup: 4

                },

                767: {
                    slidesPerView: 3,
                    slidesPerGroup: 3


                },

                576: {
                    slidesPerView: 2,
                    slidesPerGroup: 2

                },

                0: {
                    slidesPerView: 1,
                    slidesPerGroup: 1

                }
            }
        });

        var testimonialSlider = new Swiper('.testimonial-slider-container', {
            slidesPerView: 1,
            speed: 1000,
            loop: true,
            spaceBetween: 0,
            effect: 'fade',
            fadeEffect: { crossFade: true },
            autoplay: {
                delay: 2500,
                disableOnInteraction: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            }
        });

        var gallerySlider = new Swiper('.department-gallery', {
            slidesPerView: 1,
            speed: 1000,
            loop: false,
            spaceBetween: 10,
            autoplay: {
                delay: 2500,
                disableOnInteraction: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            }
        });

        var brandLogoSlider = new Swiper('.brand-logo-slider-container', {
            slidesPerView: 5,
            loop: true,
            speed: 1000,
            spaceBetween: 30,
            autoplay: false,
            breakpoints: {
                1200: {
                    slidesPerView: 5,
                    spaceBetween: 100
                },

                992: {
                    slidesPerView: 4,
                    spaceBetween: 90
                },

                768: {
                    slidesPerView: 3,
                    spaceBetween: 110

                },

                576: {
                    slidesPerView: 3,
                    spaceBetween: 60
                },

                380: {
                    slidesPerView: 3,
                    spaceBetween: 30
                },

                0: {
                    slidesPerView: 2,
                    spaceBetween: 30
                }
            }
        });

    });


    // Fancybox Js
    $('.lightbox-image').fancybox();

    //Video Popup
    $('.play-video-popup').fancybox();


    // Scroll Top Hide Show
    $(window).on('scroll', function () {
        if ($(this).scrollTop() > 250) {
            $('.scroll-to-top').fadeIn();
        } else {
            $('.scroll-to-top').fadeOut();
        }

        // Sticky Header
        if ($('.sticky-header').length) {
            var windowpos = $(this).scrollTop();
            if (windowpos >= 80) {
                $('.sticky-header').addClass('sticky');
            } else {
                $('.sticky-header').removeClass('sticky');
            }
        }

    });

    // Datepicker
    $("#datepicker").datepicker();

    //Scroll To Top
    $('.scroll-to-top').on('click', function () {
        $('html, body').animate({ scrollTop: 0 }, 800);
        return false;
    });

    // Reveal Footer JS
    let revealId = $(".reveal-footer"),
        footerHeight = revealId.outerHeight(),
        windowWidth = $(window).width(),
        windowHeight = $(window).outerHeight();

    if (windowWidth > 991 && windowHeight > footerHeight) {
        $(".site-wrapper-reveal").css({
            'margin-bottom': footerHeight + 'px'
        });
    }



    $(window).on('load', function () {
        AOS.init();
        stylePreloader();
    });


})(window.jQuery);

function viewTest(id, type) {
    $.ajax({
        method: "post",
        url: "getTestList.php",
        data: "id=" + id + '&type=' + type,
        success: function (result) {
            $(".test-list-sidebar").css("display", "block");
            $(".post-item:not(#post_item_" + id + ")").css("opacity", "0.3");
            $(".test-list-ul").html(result);
            $(document).click(() => {
                $(".test-list-sidebar").css("display", "none");
                $(".post-item:not(#post_item_" + id + ")").css("opacity", "1");

            })
        }
    });
}
function add_to_cart(q, id, table, type) {
    $.ajax({
        method: 'post',
        url: '../add_to_cart.php',
        data: 'qty=' + q + '&product_id=' + id + '&table=' + table,
        success: function (result) {
            if (result == "not_logged_in") {
                $(".alert-custom-test-page").css("display", "block");
                $(".alert-custom-test-page>strong").html("Please!");
                $(".alert-custom-test-page>span").html("login to add " + table + " into cart");
            } else if (result == "success_cart_added") {
                $(".alert-custom-test-page").css("display", "block");
                $(".alert-custom-test-page>strong").html("Nice!");
                $(".alert-custom-test-page>span").html(table + " added into cart");
                $("#btn_person_select_" + id).text("Added");
                viewCart(table, type);
            } else {
                $(".alert-custom-test-page").css("display", "block");
                $(".alert-custom-test-page>strong").html("Sorry!");
                $(".alert-custom-test-page>span").html("something went wrong.");
            }
            $("#person-select-cont" + id).toggleClass("hide-block");
            $("#btn-close").click(() => {
                $(".alert-custom-test-page").css("display", "none");
            })

        }
    });
}
function m_add_to_cart(id, table, type) {
    $.ajax({
        method: 'post',
        url: 'medicine_add_cart.php',
        data: 'product_id=' + id + '&table=' + table,
        success: function (result) {
            console.log(result)
            if (result == "not_logged_in") {
                $(".alert-custom-test-page").css("display", "block");
                $(".alert-custom-test-page>strong").html("Please!");
                $(".alert-custom-test-page>span").html("login to add " + table + " into cart");
            } else if (result == "success_cart_added") {
                $(".alert-custom-test-page").css("display", "block");
                $(".alert-custom-test-page>strong").html("Nice!");
                $(".alert-custom-test-page>span").html(table + " added into cart");
                $("#book-btn-medi_" + id).text("Added to Cart");
                viewCart(table, type);
            } 
            else if(result=="already there"){
                
            }
            else {
                $(".alert-custom-test-page").css("display", "block");
                $(".alert-custom-test-page>strong").html("Sorry!");
                $(".alert-custom-test-page>span").html("something went wrong.");
            }
            $("#btn-close").click(() => {
                $(".alert-custom-test-page").css("display", "none");
            })

        }
    });
}
function remove_cart(id, table, type) {
    $.ajax({
        method: 'post',
        url: '../removeCart.php',
        data: 'table=' + table + '&product_id=' + id,
        success: function (result) {
            if (result = 'success_cart_removed') {
                $(".alert-custom-test-page").css("display", "block");
                $(".alert-custom-test-page>strong").html("yup!");
                $(".alert-custom-test-page>span").html(table + " Removed from cart");
                $("#btn_person_select_" + id).text("BOOK NOW");
                $(".cart-remove-small-" + id).text("");

                viewCart(table, type);
            } else {
                $(".alert-custom-test-page").css("display", "block");
                $(".alert-custom-test-page>strong").html("hey!");
                $(".alert-custom-test-page>span").html(table + " already removed, please reload the page");
            }
            $("#btn-close").click(() => {
                $(".alert-custom-test-page").css("display", "none");
            })
            $("#person-select-cont" + id).toggleClass("hide-block");
        }
    });
}

function show_hide(n) {
    $("#tcDetails" + n).toggleClass("hide-block");
}
$('.collapse').on('shown.bs.collapse', function () {
    $(this).parent().find(".lnr-arrow-right").removeClass("lnr-arrow-right").addClass("lnr-arrow-left");
}).on('hidden.bs.collapse', function () {
    $(this).parent().find(".lnr-arrow-left").removeClass("lnr-arrow-left").addClass("lnr-arrow-right");
});