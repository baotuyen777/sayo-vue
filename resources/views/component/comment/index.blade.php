@push('css')
    {{--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"--}}
    {{--          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">--}}
    {{--    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">--}}
@endpush

<div class="card">
    <h2>Bình luận</h2>
    <div class="card__body ">
        <form action="{{ route('comment.store') }}" class="form__comment-ajax" method="post"
              enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="item_id" value="{{$obj->id}}">
            @include('component.comment.textarea',['name'=> 'content', 'placeholder' => 'Nhập nội dung bình luận (tiếng Việt có dấu)...'])
            <div class="btn__comment">
                <button class="btn--primary btn-submit">
                    GỬI BÌNH LUẬN
                </button>
            </div>
        </form>
    </div>
</div>

<div>
    @empty($obj->comments)
        <p>Tin đăng chưa có bình luận, bạn hãy trở thành người bình luận đầu tiên!</p>
    @else
        <div class="panel">
            <div class="panel-body p-10 white-box">
                @foreach($obj->comments as $comment)
                    @include('component.comment.comment',['comment'=> $comment])
                    @include('component.comment.reply',['id'=> $comment->id, 'parent_id' => $comment->id, 'item_id' => $obj->id])
                @endforeach
            </div>
        </div>

    @endempty
</div>

@push('js')
    <script>
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
    </script>
@endpush

