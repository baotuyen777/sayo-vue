//1.slider
jQuery(document).ready(function ($) {
    var liCount = $('.slider .slider-item').length;
    var ulWidth = liCount * 100;
    var liWidth = 100 / liCount;
    var leftIncrement = ulWidth / liCount;
    var swipeSpeed = 300;

    const $slider =$('.slider');

    $slider.find('.group-slider').width(ulWidth + '%');
    $slider.find('.slider-item').width(liWidth + '%');

    if (liCount > 2) {
        $('.slider .group-slider').css('margin-left', -leftIncrement + '%');
        $('.slider .group-slider .slider-item:last-child').prependTo('.slider .group-slider');
    } else if (liCount == 1) {
        $('.slider span').css('display', 'none');
        $('.autoPlay').css('display', 'none');
    }

    function moveLeft() {
        $('.slider .group-slider').animate(
            {
                left: -leftIncrement + '%',
            },
            swipeSpeed,
            function () {
                $('.slider .group-slider .slider-item:first-child').appendTo('.slider .group-slider');
                $('.slider .group-slider').css('left', '');

                if ($('.navigator span').hasClass('active')) {
                    if ($('.navigator span.active').is(':last-child')) {
                        $('span.active').removeClass('active');
                        $('.navigator span:first-child').addClass('active');
                    } else {
                        $('span.active').next().addClass('active');
                        $('span.active').prev().removeClass('active');
                    }
                }
            }
        );
    }

    function moveRight() {
        $('.slider .group-slider').animate(
            {
                left: leftIncrement + '%',
            },
            swipeSpeed,
            function () {
                $('.slider .group-slider .slider-item:last-child').prependTo('.slider .group-slider');
                $('.slider .group-slider').css('left', '');

                if ($('.navigator span').hasClass('active')) {
                    if ($('.navigator span.active').is(':first-child')) {
                        $('span.active').removeClass('active');
                        $('.navigator span:last-child').addClass('active');
                    } else {
                        $('span.active').prev().addClass('active');
                        $('span.active').next().removeClass('active');
                    }
                }
            }
        );
    }


    $('.ad-image-prev').click(function () {
        moveRight();
    });

    $('.ad-image-next').click(function () {
        moveLeft();
    });

    var touchstartX = 0;
    var touchendX = 0;

    $('.slider .group-slider').on('touchstart', function (e) {
        touchstartX = e.originalEvent.touches[0].pageX;
    });

    $('.slider .group-slider').on('touchend', function (e) {
        touchendX = e.originalEvent.changedTouches[0].pageX;
        handleGesture();
    });


    function handleGesture() {
        var swipeThreshold = 1;

        if (touchendX < touchstartX - swipeThreshold) {
            moveLeft();
        }

        if (touchendX > touchstartX + swipeThreshold) {
            moveRight();
        }
    }

});
