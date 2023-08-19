jQuery(document).ready(function ($) {
    let screenWidth = $(window).width();
    // if (screenWidth < 768) {
    //     $('.slider ul li').css({width: screenWidth, height: 200});
    // }
    const item =$('.post-slider .item')
    var slideCount = item.length;
    var slideWidth = item.width();
    var slideHeight = item.height();
    var sliderUlWidth = slideCount * slideWidth;
    // $('.post-slider').css({width: slideWidth, height: slideHeight});
    $('.post-slider .slick-track').css({width: sliderUlWidth, marginLeft: -slideWidth});
    console.log(slideWidth,slideCount,222)
    // $('.slider ul').css({width: sliderUlWidth});
    //
    // $('.slider ul li:last-child').prependTo('.slider ul');

    // function moveLeft() {
    //     $('.post-slider .slick-track').animate({
    //         left: +slideWidth
    //     }, 1000, function () {
    //         $('.slider ul li:last-child').prependTo('.slider ul');
    //         $('.slider ul').css('left', '');
    //     });
    // };

    function moveRight() {
        $('.post-slider .slick-track').animate({
            left: -slideWidth
        }, 1000, function () {
            $('.post-slider .slick-track .item:first-child').appendTo('.slider ul');
            $('.post-slider .slick-track ').css('left', '');
        });
    };

    $('a.control_prev').click(function () {
        moveLeft();
    });

    $('a.control_next').click(function () {
        moveRight();
    });

});
