jQuery(document).ready(function ($) {
    let screenWidth = $(window).width();
    // if (screenWidth < 768) {
    //     $('.slider ul li').css({width: screenWidth, height: 200});
    // }
    const slide = $('.post-slider .slick-track')
    const item = $('.post-slider .item')
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

jQuery('.account-menu').click(function () {
    jQuery(this).find('.menu').toggle('show')
});

jQuery('.select5__button').click(function (){
//
    jQuery(this).parent().find('.select5__body').toggleClass('show')
})
// jQuery('body').click(() => {
//     jQuery('.account-menu').find('.menu').hide()
// })


// function callAjaxForm(e, form, success) {
//     e.preventDefault();
//     var $form = $(form);
//     var data = new FormData(form);
//     jQuery.ajax({
//         type: "POST",
//         url: $form.attr('action'),
//         data: new FormData(form),
//         contentType: false,
//         cache: false,
//         processData: false, //
//         beforeSend: function () {
//             $form.find('button').addClass('loading');
//             $form.find('.btn_sumbit').attr('disabled', true);
//         },
//         success
//     });
// }

// jQuery('.form_ajax').submit(function (e) {
//     var form = $(this);
//
//     callAjaxForm(e, this, function (result) {
//         form.find('button').removeClass('loading');
//         if (result.status) {
//             toastr.success(result.mes);
//             if (form.find('.btn_back').length > 0) {
//                 setTimeout(window.location.href = jQuery(".btn_back").attr('href'), 1000)
//             }
//         } else {
//             toastr.error(result.mes);
//         }
//
//     });
// });

if (jQuery('.ire0wc').val()) {
    jQuery('.ire0wc').addClass('hasValue')
} else {
    jQuery('.ire0wc').removeClass('hasValue')
}
jQuery('.ire0wc').change(function () {
    if (jQuery(this).val()) {
        jQuery(this).addClass('hasValue')
    } else {
        jQuery(this).removeClass('hasValue')
    }
});

jQuery('.btn_addfile').click(function (e) {
    e.preventDefault();
    $('#files').click();
});

jQuery('.notify').find('button').click(() => {
    jQuery('.notify').fadeOut();
})

const showNotify = (text = 'Thành công', type = 'success') => {
    jQuery('.notify').fadeOut().addClass(type)
    $('.notify .content').html(text);
    $('.notify').fadeIn();
    setTimeout(() => jQuery('.notify').fadeOut(), 5000)
}
jQuery('.form-ajax').on('submit', function (event) {
    event.preventDefault();
    event.stopPropagation();

    var $form = $(this);
    const isPut = $(this).data('id');
    let data = isPut ? $(this).serialize() : new FormData(this);
    if (state?.file_ids?.length) {
        state.file_ids.forEach((item) => data.append("file_ids[]", item))
    }

    $(`.validate`).html('');
    $(`.form-control`).removeClass('error');
    $.ajax({
        url: jQuery('.form-ajax').attr('action'),
        data,
        processData: false,
        contentType: isPut ? 'application/x-www-form-urlencoded' : false,
        type: isPut ? 'PUT' : 'POST',
        success: function (res) {
            if (res.status) {
                showNotify();
                if ($form.find(".btn-back")[0]) {
                    setTimeout(() => $form.find(".btn-back")[0].click(), 2000)
                }

            }
        },
        error: (jqXHR, textStatus, error) => {
            const errors = JSON.parse(jqXHR.responseText).errors;
            Object.keys(errors).forEach(field => {
                $(`.validate-${field}`).html(errors[field][0])
                $(`.form-control-${field}`).addClass('error')
            })
            showNotify(JSON.parse(jqXHR.responseText).message, 'error')
            console.log(errors)
        }
    });

});

$(document).ready(function () {
    $('#files').change(function () {
        var form_data = new FormData();

        // Read selected files
        var totalfiles = document.getElementById('files').files.length;
        for (var index = 0; index < totalfiles; index++) {
            form_data.append("files[]", document.getElementById('files').files[index]);
        }
        const formControl = $(this).parent();
        $.ajax({
            url: '/api/files',
            type: 'post',
            data: form_data,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status) {
                    state.file_ids = state.file_ids.concat(response.ids);
                    for (let index = 0; index < response.result.length; index++) {
                        var src = response.result[index].url_full;
                        // Add img element in <div id='preview'>
                        formControl.find('.preview').append(`<img src="${src}">`);
                    }
                }
            },
        });
    });

});

