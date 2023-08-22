jQuery(document).ready(function ($) {
    let screenWidth = $(window).width();
    // if (screenWidth < 768) {
    //     $('.slider ul li').css({width: screenWidth, height: 200});
    // }
    const slide =$('.post-slider .slick-track')
    const item =$('.post-slider .item')
    var slideCount = item.length;
    var slideWidth = 620;

    var sliderUlWidth = slideCount * slideWidth;
    slide.css({width: sliderUlWidth, marginLeft: -slideWidth});
    // slide.css({width: sliderUlWidth});
    //
    // $('.slider ul li:last-child').prependTo('.slider ul');

    function moveLeft() {
        $('.post-slider .slick-track').animate({
            left: +slideWidth
        }, 200, function () {
            $('.post-slider .slick-track .item:last-child').prependTo('.post-slider .slick-track');
            slide.css('left', '');
        });
    };

    function moveRight() {
        // $('.post-slider .slick-track').attr('margin-left',0)
        $('.post-slider .slick-track').animate({
            left: -slideWidth
        }, 200, function () {
            $('.post-slider .slick-track .item:first-child').appendTo('.post-slider .slick-track');
            slide.css('margin-left', '');
        });
    };

    $('.control_prev').click(function () {
        console.log(2212);
        moveLeft();
    });

    $('.control_next').click(function () {
        moveRight();
    });

});
