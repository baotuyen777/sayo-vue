// 2. form ajax
jQuery('.form-ajax').on('submit', function (event) {
    event.preventDefault();
    event.stopPropagation();
    if ($(this).find('.tinymce').html()) {
        // tinymce.triggerSave();
    }

    const confirmText = $(this).data('confirm');
    if (confirmText && !confirm(confirmText) == true) {
        return;
    }

    var $form = $(this);
    const isPut = $(this).data('id');
    // let data = isPut ? $(this).serialize() : new FormData(this);
    let formData = new FormData(this);

    if (state?.file_ids?.length) {
        // console.log(state?.file_ids,2221)
        console.log(state?.file_ids);
        state.file_ids.forEach((item) => formData.append("file_ids[]", item))
    }
    // console.log(formData.file_ids);
    if (isPut) {
        formData = new URLSearchParams(formData).toString();
        console.log(formData,2323);
    }

    $(`.validate`).html('');
    $(`.form-control`).removeClass('error');
    toggleLoading()
    $form.find('.btn-submit').attr('disabled', true);
    console.log(1231);
    $.ajax({
        url: $form.attr('action'),
        data: formData,
        processData: false,
        contentType: isPut ? 'application/x-www-form-urlencoded' : false,
        type: isPut ? 'PUT' : 'POST',
        success: function (res) {
            if (res.status) {
                console.log(res,223333)
                showNotify(res.message);
                if ($form.find(".btn-back")[0]) {
                    setTimeout(() => $form.find(".btn-back")[0].click(), 2000)
                }

                if (res?.redirectUrl) {
                    window.location.href = res?.redirectUrl
                }
            }else {
                showNotify(res.message,'danger');
            }
            toggleLoading()
            $form.find('.btn-submit').attr('disabled', false);
        },
        error: (jqXHR) => {
            // Reset Google reCAPTCHA
            if (typeof grecaptcha !== 'undefined') {
                grecaptcha.reset();
            }
            
            const errors = JSON.parse(jqXHR.responseText).errors;
            if(errors){
                Object.keys(errors).forEach(field => {
                    $(`.validate-${field}`).html(errors[field][0])
                    $(`.form-control-${field}`).addClass('error')
                })
                showNotify(JSON.parse(jqXHR.responseText).message, 'error')
            }else{
                showNotify(JSON.parse(jqXHR.responseText).message, 'error');
            }
            console.log(errors);
            console.log(JSON.parse(jqXHR.responseText,111));
            toggleLoading()
            $form.find('.btn-submit').attr('disabled', false);
        }
    });

});

//3. upload
const inputFiles = document.getElementsByClassName('input-files');
for (const inputFile of inputFiles) {
    inputFile.addEventListener('change', function () {
        const totalFiles = this?.files?.length || 0;
        // console.log(totalFiles)
        const form_data = new FormData();
        for (var index = 0; index < totalFiles; index++) {
            // form_data.append("files[]", document.getElementById('files').files[index]);
            form_data.append("files[]", this.files[index]);
        }
        const formControl = $(this).parent();
        toggleLoading();
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
                toggleLoading();
            },
            error: function (jqXHR){
                showNotify(JSON.parse(jqXHR.responseText).message, 'error');
            }
        });
    })
    // console.log(inputFile);
}

// $('.input-files1').change(function () {
//     console.log(1231)
//     var form_data = new FormData();
//     // Read selected files
//     // var totalfiles = document.getElementsByClassName('files').files.length;
//     // console.log($(this).val());
//     // var totalfiles = $(this).files.length
//     for (var index = 0; index < totalfiles; index++) {
//         // form_data.append("files[]", document.getElementById('files').files[index]);
//         form_data.append("files[]", document.getElementById('files').files[index]);
//     }
//     const formControl = $(this).parent();
//     toggleLoading();
//     $.ajax({
//         url: '/api/files',
//         type: 'post',
//         data: form_data,
//         dataType: 'json',
//         contentType: false,
//         processData: false,
//         success: function (response) {
//             if (response.status) {
//                 state.file_ids = state.file_ids.concat(response.ids);
//                 for (let index = 0; index < response.result.length; index++) {
//                     var src = response.result[index].url_full;
//                     // Add img element in <div id='preview'>
//                     formControl.find('.preview').append(`<img src="${src}" alt="">`);
//                 }
//             }
//             toggleLoading();
//         },
//     });
// });

//4. button confirm api
$('.btn-ajax').click(function () {
    const $this = $(this);

    const data = {_token: $('.csrf').html(), ...$this.data('param')}
    const type = $this.data('method') || 'put'

    $this.attr('disabled', true)
    toggleLoading()
    $.ajax({
        url: $this.data('url'),
        data,
        type,
        // contentType: type == 'put' ? 'application/x-www-form-urlencoded' : false,
        dataType: 'json',
        success: function (response) {
            if (response.status) {
                window.location.reload()
            }
            $this.attr('disabled', false)
            toggleLoading();
        },
    });
})

//5.modal
$(document).ready(function () {
    $(".btn-modal").click(function () {
        $("#blackout").addClass("visable");
        $("#" + $(this).data('modal-id')).addClass("visable");

    });
    $("#blackout, .close").click(function () {
        $("#blackout").removeClass("visable");
        $(".modal").removeClass("visable");
    });
});
//6. setting-dropdown
$('.btn-3dot').click(function () {
    $(this).parent().find('.dropdown').toggleClass('dropdown--open')
})
$('.btn-3dot').blur(function () {
    setTimeout(() => $(this).parent().find('.dropdown').removeClass('dropdown--open'), 300)
})
jQuery('.account-menu').click(function () {
    jQuery(this).find('.menu-items').toggle('show')
});

//form
jQuery('.dropdown__button').click(function () {

    jQuery('.dropdown').removeClass('show')
    jQuery(this).parent().toggleClass('show')
})

$('.dropdown__close').click(function () {
    jQuery(this).parents('.dropdown').removeClass('show')
})

$('.clear').click(function () {
    $(this).parents('.dropdown').find('input').val('');
    $(this).parents('form').submit();
})

// $('body').find('a').click(function (e) {
//     toggleLoading();
// })

function toggleLoading() {
    $('.overlay').toggle();
    setTimeout(function () {
        $('.overlay').toggle()
    }, 5000)
}

$(document).ready(function () {
    //form effect
    $('.minput').each(function () {
        if ($(this).val()) {
            $(this).addClass('hasValue')
        } else {
            $(this).removeClass('hasValue')
        }
    })
})


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
    $(this).parent().find('.input-files').click();
});

//selection
$('.selection').find('.minput').focus(function () {
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
//dusk test
var url = new URL(window.location.href);
var dusktext = url.searchParams.get("dtext");
var dclass = url.searchParams.get("dstatus") == 1 ? "success" : "danger";
let element = document.getElementById("dusktext");
if (!dusktext) element.style.visibility = "hidden";
element.innerHTML = dusktext;
element.classList.add(dclass);

$(document).ready(function () {
    $('.portfolio__tab .children_menu').click(function () {
        $('.portfolio__tab .children_menu').removeClass('activelink');
        $(this).addClass('activelink');
        var tabid = $(this).data('tab');
        $('.list-data').removeClass('active-tab').addClass('hide-tab');
        $('#' + tabid).addClass('active-tab').removeClass('hide-tab');
    });
});

$('.btn-like-page').on('click', function (e) {
    e.preventDefault()
    $('#formLikePage').submit()
})

