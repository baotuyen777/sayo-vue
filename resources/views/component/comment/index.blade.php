@extends('layout.index')

@push('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

    <style>
        .rely-content {
            border: 1px solid #ccc;
        }

        .rely-content:focus-visible {
            outline: none;
            border-color: #3c8dbc;
        }
    </style>
@endpush

@section('content')
    <main class="container">
        <div class="card">
            <h2>Bình luận</h2>
            <div class="card__body ">
                <form action="{{ route('comment.store') }}" class="form__comment-ajax" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="item_id" value="1">
                    @include('component.comment.textarea',['name'=> 'content', 'placeholder' => 'Nhập nội dung bình luận (tiếng Việt có dấu)...'])
                    <div class="btn__comment">
                        <button class="aw__b1358qut primary r-normal medium w-bold btn-right aw__h1gb9yk btn-submit">
                            GỬI BÌNH LUẬN
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-12 bootstrap snippets">
            @isset($postComments)
                <div class="panel">
                    <div class="panel-body">
                        @foreach($postComments as $comment)
                            <div class="media-block">
                                <a class="media-left" href="#">
                                    <img class="img-circle img-sm"
                                         src="https://bootdey.com/img/Content/avatar/avatar1.png"
                                         alt="Profile Picture">
                                </a>
                                <div class="media-body">
                                    <div class="mar-btm">
                                        <p>{{ data_get($comment, 'user.name') }}</p>
                                        <p class="text-muted text-sm">{{ $comment->remaining_days }}</p>
                                    </div>
                                    <p>{{ data_get($comment, 'content') }}</p>
                                    <div class="pad-ver">
                                        <div class="btn-group">
                                            <a class="btn btn-sm btn-default btn-hover-success" href="#"><i
                                                    class="fa fa-thumbs-up"></i></a>
                                            <a class="btn btn-sm btn-default btn-hover-danger" href="#"><i
                                                    class="fa fa-thumbs-down"></i></a>
                                        </div>
                                        <button
                                            class="btn btn-sm btn-default btn-hover-primary"
                                            data-toggle="reply-form"
                                            data-target="comment-{{$comment->id}}-reply-form">Bình luận
                                        </button>
                                        <!-- Reply form start -->
                                        @include('component.comment.reply',['id'=> $comment->id, 'parent_id' => $comment->id, 'item_id' => 1])
                                        <!-- Reply form end -->
                                    </div>
                                    <hr>
                                    <div>
                                        @foreach($comment->children as $childComment)
                                            <div class="media-block">
                                                <a class="media-left" href="#">
                                                    <img class="img-circle img-sm"
                                                         src="https://bootdey.com/img/Content/avatar/avatar3.png"
                                                         alt="Profile Picture">
                                                </a>
                                                <div class="media-body">
                                                    <div class="mar-btm">
                                                        <p>{{ data_get($childComment, 'user.name') }}</p>
                                                        <p class="text-muted text-sm">{{ $childComment->remaining_days ?? '' }}</p>
                                                    </div>
                                                    <p>{{ data_get($childComment, 'content') }}</p>
                                                    <div class="pad-ver">
                                                        <div class="btn-group">
                                                            <a class="btn btn-sm btn-default btn-hover-success">
                                                                <i class="fa fa-thumbs-up"></i>
                                                            </a>
                                                            <a class="btn btn-sm btn-default btn-hover-danger">
                                                                <i class="fa fa-thumbs-down"></i>
                                                            </a>
                                                        </div>
                                                        <button
                                                            class="btn btn-sm btn-default btn-hover-primary"
                                                            data-toggle="reply-form"
                                                            data-target="comment-{{$childComment->id}}-reply-form">Bình
                                                            luận
                                                        </button>
                                                        <!-- Reply form start -->
                                                        @include('component.comment.reply',['id'=> $childComment->id, 'parent_id' => $comment->id, 'item_id' => 1])
                                                        <!-- Reply form end -->
                                                    </div>
                                                    <hr>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endisset
        </div>
    </main>
@endsection

@push('js')
    <script>
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
                    console.log(res);
                    if (res.status) {
                        // showNotify();

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
    </script>
@endpush

