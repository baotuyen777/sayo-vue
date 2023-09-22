<div class="pagination">
    @if ($objs->onFirstPage())
        <span class="pagination__link pagination__link--prev pagination__link--disabled">Trang đầu</span>
    @else
        <a href="{{ $objs->previousPageUrl() }}" class="pagination__link pagination__link--prev">Trang cuối</a>
    @endif

    @foreach ($objs->getUrlRange(1, $objs->lastPage()) as $page => $url)
        @if ($page == $objs->currentPage())
            <span class="pagination__link pagination__link--active">{{ $page }}</span>
        @else
            <a href="{{ $url }}" class="pagination__link">{{ $page }}</a>
        @endif
    @endforeach

    @if ($objs->hasMorePages())
        <a href="{{ $objs->nextPageUrl() }}" class="pagination__link pagination__link--next">Next</a>
    @else
        <span class="pagination__link pagination__link--next pagination__link--disabled">Next</span>
    @endif
</div>
