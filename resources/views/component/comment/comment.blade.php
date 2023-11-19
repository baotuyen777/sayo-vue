<div class="comment-show">
    <a class="comment__avatar" href="#">
        <img class="img-circle img-sm"
             src="https://bootdey.com/img/Content/avatar/avatar1.png"
             alt="Profile Picture">
    </a>
    <div class="media-body">
        <div class="comment__content">
            <div>{{ data_get($comment, 'user.name') }} <span
                    class="text-muted text-sm">{{ $comment->remaining_days }}</span></div>
            <div>{{ data_get($comment, 'content') }}</div>
        </div>
        {{--        <div class="comment__action">--}}
        {{--            <em class="btn--reply" data-target="reply-form-{{$comment->id}}">Phản hồi</em>--}}
        {{--            <span class="text-muted text-sm">{{ $comment->remaining_days }}</span>--}}
        {{--        </div>--}}
        {{--        @include('component.comment.reply',['id'=> $comment->id, 'parent_id' => $comment->id, 'item_id' => $obj->id])--}}

        @foreach($comment->children as $child)
            @include('component.comment.comment',['comment'=> $child])
        @endforeach
    </div>
</div>
