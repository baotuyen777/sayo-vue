@extends('layout.manager')

@section('content')
    <div class="d-flex-wrap grid-2">
        @foreach($posts as $post)
            @include('component.post.post-horizontal',['post' => $post])
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
