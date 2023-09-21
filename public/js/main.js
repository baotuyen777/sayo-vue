jQuery(document).ready(function ($) {
    // let screenWidth = $(window).width();
    // if (screenWidth < 768) {
    //     $('.slider ul li').css({width: screenWidth, height: 200});
    // }
    const slide = jQuery('.post-slider .slick-track')
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
    }

    function moveRight() {
        // $('.post-slider .slick-track').attr('margin-left',0)
        $('.post-slider .slick-track').animate({
            left: -slideWidth
        }, 200, function () {
            $('.post-slider .slick-track .item:first-child').appendTo('.post-slider .slick-track');
            slide.css('margin-left', '');
        });
    }

    $('.control_prev').click(function () {
        console.log(2212);
        moveLeft();
    })

    $('.control_next').click(function () {
        moveRight();
    })

});

jQuery('.account-menu').click(function () {
    jQuery(this).find('.menu').toggle('show')
});

jQuery('.dropdown__button').click(function () {

    jQuery('.dropdown').removeClass('show')
    jQuery(this).parent().toggleClass('show')
})

$('.dropdown__close').click(function () {
    jQuery(this).parents('.dropdown').removeClass('show')
})
jQuery('.dropdown__button').blur(function () {
    // jQuery(this).parent().find('.dropdown__content').removeClass('show')
})

// jQuery('.dropdown__content').find('a').click(function(){
//     console.log(window.location.href);
// })
// jQuery('body').click(() => {
//     jQuery('.account-menu').find('.menu').hide()
// })

$('a, .btn-submit').click(function(e){
    $('.loader').show();
})




//form effect
if (jQuery('.minput').val()) {
    jQuery('.minput').addClass('hasValue')
} else {
    jQuery('.minput').removeClass('hasValue')
}
jQuery('.minput').keyup(function () {
    if (jQuery(this).val()) {
        jQuery(this).addClass('hasValue')
        $(this).parent().find('.btn-close').addClass('show');
    } else {
        jQuery(this).removeClass('hasValue')
        $(this).parent().find('.btn-close').removeClass('show');
    }
});
$('.btn-close').click(function () {
    $(this).parent().find('.minput').val(null);
    jQuery('.minput').removeClass('hasValue')
    $(this).removeClass('show');
})

jQuery('.btn_addfile').click(function (e) {
    e.preventDefault();
    $('#files').click();
});

//selection
$('.selection').find('.minput').focus(function () {
    console.log(11231)
    $(this).parents('.selection').find('.selection__list').toggleClass('show')
})
$('.selection__list').on('click', 'li', function () {
    const selection = $(this).parents('.selection');
    const li = $(this);
    selection.find('.input').val(li.data('id'))
    selection.find('.minput').val(li.html())
    selection.find('.minput').addClass('hasValue')
    selection.find('.btn-close').addClass('show');
    selection.find('.selection__list').removeClass('show');
    if (selection.data('async-url')) {
        $.ajax({
            url: selection.data('async-url') + '/' + li.data('id'),
            success: function (response) {
                if (response.status) {
                    let html = '';
                    response.result.forEach((obj) => {
                        html += `<li data-id="${obj.id}">${obj.name}</li>`
                    })
                    $('#' + selection.data('async-field')).find('.selection__list').html(html)
                }
            },
        });
    }

})


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
        error: (jqXHR) => {
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
                        formControl.find('.preview').append(`<img src="${src}" alt="">`);
                    }
                }
            },
        });
    });

});

