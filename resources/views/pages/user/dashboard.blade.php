@extends('layout.manager')

@section('content')
    <div class="d-flex-wrap grid-2 list-data" id="page1">
        @foreach($posts as $post)
            @include('component.post.post-horizontal',['post' => $post])
        @endforeach
    </div>
    <div class="d-flex-wrap grid-2 list-data hide-tab" id="page2">
        @foreach($ratings as $rating)
        <div class="comment-show">
            <a class="comment__avatar" href="#">
                <img class="img-circle img-sm"
                     src="https://bootdey.com/img/Content/avatar/avatar1.png"
                     alt="Profile Picture">
            </a>
            <div class="media-body">
                <div class="comment__content">
                    <div>
                        {{ $rating->user->name }}
                        <span class="text-muted text-sm">{{ $rating->remaining_days }}</span>
                    </div>
                    <div>
                        {{ $rating->content }}
                    </div>
                </div>
                {{--        <div class="comment__action">--}}
                {{--            <em class="btn--reply" data-target="reply-form-{{$comment->id}}">Phản hồi</em>--}}
                {{--            <span class="text-muted text-sm">{{ $comment->remaining_days }}</span>--}}
                {{--        </div>--}}
                {{--        @include('component.comment.reply',['id'=> $comment->id, 'parent_id' => $comment->id, 'item_id' => $obj->id])--}}
        
                {{-- @foreach($comment->children as $child)
                    @include('component.comment.comment',['comment'=> $child])
                @endforeach --}}
            </div>
        </div>
        @endforeach
    </div>
    <div class="d-flex-wrap grid-2 list-data hide-tab" id="page3">
        @foreach($products as $product)
            @include('component.post.post-horizontal',['product' => $product])
        @endforeach
    </div>

    <div class="pagination">
        @if ($posts->onFirstPage())
            <span class="pagination__link pagination__link--prev pagination__link--disabled">Trang đầu</span>
        @else
            <a href="{{ $posts->previousPageUrl() }}" class="pagination__link pagination__link--prev">Trang cuối</a>
        @endif

        @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
            @if ($page == $posts->currentPage())
                <span class="pagination__link pagination__link--active">{{ $page }}</span>
            @else
                <a href="{{ $url }}" class="pagination__link">{{ $page }}</a>
            @endif
        @endforeach

        @if ($posts->hasMorePages())
            <a href="{{ $posts->nextPageUrl() }}" class="pagination__link pagination__link--next">Next</a>
        @else
            <span class="pagination__link pagination__link--next pagination__link--disabled">Next</span>
        @endif
    </div>
@endsection
