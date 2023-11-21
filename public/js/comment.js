$('.btn--reply').click(function () {
    $("#" + $(this).data('target')).toggle();
})
document.addEventListener(
    "click",
    function (event) {
        let target = event.target;
        let replyForm;
        if (target.matches("[data-toggle='reply-form']")) {
            replyForm = document.getElementById(target.getAttribute("data-target"));
            replyForm.classList.toggle("d-none");
        }
    },
    false
);

jQuery('.form__comment-ajax').on('submit', function (event) {
    event.preventDefault();
    event.stopPropagation();

    var $form = $(this);
    const isPut = $(this).data('id');
    let data = isPut ? $(this).serialize() : new FormData(this);

    $(`.validate`).html('');
    $(`.form-control`).removeClass('error');
    $.ajax({
        url: jQuery('.form__comment-ajax').attr('action'),
        data,
        processData: false,
        contentType: isPut ? 'application/x-www-form-urlencoded' : false,
        type: isPut ? 'PUT' : 'POST',
        success: function (res) {
            window.location.reload();
        },
        error: (jqXHR) => {
            const errors = JSON.parse(jqXHR.responseText).errors;
            if (typeof errors !== 'undefined') {
                Object.keys(errors).forEach(field => {
                    $(`.validate-${field}`).html(errors[field][0])
                    $(`.form-control-${field}`).addClass('error')
                })
            }
            showNotify(JSON.parse(jqXHR.responseText).message, 'error')
        }
    });

});
