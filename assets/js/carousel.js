$(document).ready(function() {
    var autoSlideInterval;
    
    function startAutoSlide(container) {
        autoSlideInterval = setInterval(function() {
            var $carousel = container.find('.medi-carousel');
            var itemWidth = $carousel.find('.medi-carousel-item').outerWidth(true);
            moveCarousel(container, 'next', itemWidth);
        }, 4000);
    }
    
    function stopAutoSlide() {
        clearInterval(autoSlideInterval);
    }
    
    function updateCarousel(container) {
        var $carousel = container.find('.medi-carousel');
        var numVisibleSlides = 5; 
        if ($(window).width() < 992) {
            numVisibleSlides = 4; 
        }
        if ($(window).width() < 768) {
            numVisibleSlides = 3;
        }
        if ($(window).width() < 576) {
            numVisibleSlides = 2; 
        }
        if ($(window).width() < 400) {
            numVisibleSlides = 1; 
        }
        var itemWidth = 100 / numVisibleSlides;
        $carousel.find('.medi-carousel-item').css('width', itemWidth + '%');
    }

    function moveCarousel(container, direction, itemWidth) {
        var $carousel = container.find('.medi-carousel');
        var currentPosition = parseInt($carousel.css('left')) || 0;
        var newPosition;
    
        if (direction === 'next') {
            newPosition = currentPosition - itemWidth;
        } else if (direction === 'prev') {
            newPosition = currentPosition + itemWidth;
        }
    
        $carousel.css('transition', 'left 0s ease-in-out');
        $carousel.css('left', newPosition + 'px');
    
        setTimeout(function() {
            $carousel.css('transition', '');
            if (direction === 'next') {
                $carousel.children('.medi-carousel-item').first().appendTo($carousel);
            } else if (direction === 'prev') {
                $carousel.children('.medi-carousel-item').last().prependTo($carousel);
            }
            $carousel.css('left', '0px');
        }, 0); // Adjust this time to match the transition duration (0.4s)
    }
    
    $('.medi-prev-btn').click(function() {
        var $container = $(this).closest('.medi-carousel-container');
        stopAutoSlide(); // Stop auto-sliding
        moveCarousel($container, 'prev');
    });
    
    $('.medi-next-btn').click(function() {
        var $container = $(this).closest('.medi-carousel-container');
        stopAutoSlide(); // Stop auto-sliding
        moveCarousel($container, 'next');
    });
        
    $(window).resize(function() {
        $('.medi-carousel-container').each(function() {
            updateCarousel($(this));
        });
    });

    $('.medi-carousel-container').each(function() {
        updateCarousel($(this));
        startAutoSlide($(this)); // Start auto-sliding for each carousel
    });
    
    $('.medi-carousel-container').on('mouseenter', function() {
        stopAutoSlide(); // Stop auto-sliding when mouse enters the carousel
    }).on('mouseleave', function() {
        startAutoSlide($(this)); // Start auto-sliding again when mouse leaves the carousel
    });
});
