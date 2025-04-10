@section('title', 'User Portfolio')

<div>
    <div class="header">
        <div class="container">
            <div class="header__backdrop">
                <img src="{{ asset('img/banner/default-backdrop.png') }}" alt="user-backdrop">
            </div>
            <div class="header__profile">
                <div class="group__infor">
                    <div class="avatar">
                        <div class="border-avatar">
                            <img alt="Avatar" src="{{ asset('img/icon/default_user.png') }}">
                        </div>
                    </div>
                    <div class="infor">
                        <h1>
                            {{ $user->name }}
                            <svg viewBox="0 0 12 13" width="16" height="16" fill="currentColor" 
                                 title="Verified Account" 
                                 class="icon-vertify-account {{ $user->verified ? '' : 'not-vertify' }}">
                                <g fill-rule="evenodd" transform="translate(-98 -917)">
                                    <path d="m106.853 922.354-3.5 3.5a.499.499 0 0 1-.706 0l-1.5-1.5a.5.5 0 1 1 .706-.708l1.147 1.147 3.147-3.147a.5.5 0 1 1 .706.708m3.078 2.295-.589-1.149.588-1.15a.633.633 0 0 0-.219-.82l-1.085-.7-.065-1.287a.627.627 0 0 0-.6-.603l-1.29-.066-.703-1.087a.636.636 0 0 0-.82-.217l-1.148.588-1.15-.588a.631.631 0 0 0-.82.22l-.701 1.085-1.289.065a.626.626 0 0 0-.6.6l-.066 1.29-1.088.702a.634.634 0 0 0-.216.82l.588 1.149-.588 1.15a.632.632 0 0 0 .219.819l1.085.701.065 1.286c.014.33.274.59.6.604l1.29.065.703 1.088c.177.27.53.362.82.216l1.148-.588 1.15.589a.629.629 0 0 0 .82-.22l.701-1.085 1.286-.064a.627.627 0 0 0 .604-.601l.065-1.29 1.088-.703a.633.633 0 0 0 .216-.819"></path>
                                </g>
                            </svg>
                        </h1>
                        <p>{{ $user->email }}</p>
                        <div class="edit-profile">
                            @if(Auth::check() && Auth::user()->id !== $user->id)
                                <button class="btn {{ $isLike ? 'btn--danger' : 'btn--primary' }}">
                                    <span @class('d-flex align-items-center gap-2')>
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" id="like-icon"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M15.9 4.5C15.9 3 14.418 2 13.26 2c-.806 0-.869.612-.993 1.82-.055.53-.121 1.174-.267 1.93-.386 2.002-1.72 4.56-2.996 5.325V17C9 19.25 9.75 20 13 20h3.773c2.176 0 2.703-1.433 2.899-1.964l.013-.036c.114-.306.358-.547.638-.82.31-.306.664-.653.927-1.18.311-.623.27-1.177.233-1.67-.023-.299-.044-.575.017-.83.064-.27.146-.475.225-.671.143-.356.275-.686.275-1.329 0-1.5-.748-2.498-2.315-2.498H15.5S15.9 6 15.9 4.5zM5.5 10A1.5 1.5 0 0 0 4 11.5v7a1.5 1.5 0 0 0 3 0v-7A1.5 1.5 0 0 0 5.5 10z"/>
                                        </svg>
                                        <span>{{ $isLike ? 'Unlike' : 'Like' }}</span>
                                    </span>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="detail-infor">
                    <p class="d-flex gap-10">
                        <a href="#">Followers: <b>{{ $followers_count ?? 0 }}</b></a>
                        <a href="#">Following: <b>{{ $following_count ?? 0 }}</b></a>
                    </p>
                </div>
            </div>
            
            <section class="portfolio__tab">
                @php
                    $tabs = [
                        'posts' => 'Posts',
                        'products' => 'Products',
                        'ratings' => 'Ratings'
                    ];
                @endphp

                @foreach($tabs as $key => $label)
                    <div
                        class="children_menu {{ $key === 'posts' ? 'activelink' : '' }}"
                        title="{{ ucfirst($key) }}"
                        data-tab="{{ $key }}-tab">
                        <span>{{ $label }}</span>
                    </div>
                @endforeach
            </section>
        </div>
    </div>

    <div class="list-data" id="posts-tab">
        <div class="d-flex-wrap grid-4">
            @if($posts->count() > 0)
                @foreach($posts as $post)
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5>{{ $post->title }}</h5>
                                <p>{{ Str::limit($post->content, 100) }}</p>
                                <a href="{{ route('postView', ['catCode' => $post->category->code, 'code' => $post->code]) }}" class="btn btn-sm btn-primary">View</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="notice-empty">
                    <p>No posts available.</p>
                </div>
            @endif
        </div>
    </div>

    <div class="list-data hide-tab" id="products-tab">
        <div class="d-flex-wrap grid-4">
            @if($products->count() > 0)
                @foreach($products as $product)
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5>{{ $product->name }}</h5>
                                <p>{{ $product->price }}</p>
                                <a href="{{ route('productView', ['catCode' => $product->category->code, 'code' => $product->code]) }}" class="btn btn-sm btn-primary">View</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="notice-empty">
                    <p>No products available.</p>
                </div>
            @endif
        </div>
    </div>

    <div class="d-flex-wrap grid-2 list-data hide-tab" id="ratings-tab">
        @if($ratings->count() > 0)
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
                                {{ $rating->user->name ?? 'Anonymous' }}
                                <span class="text-muted text-sm">{{ $rating->created_at->diffForHumans() }}</span>
                            </div>
                            <div>
                                {{ $rating->content }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="notice-empty">
                <p>No ratings available.</p>
            </div>
        @endif
    </div>

    <div class="pagination">
        @if ($posts->onFirstPage())
            <span class="pagination__link pagination__link--prev pagination__link--disabled">First</span>
        @else
            <a href="{{ $posts->previousPageUrl() }}" class="pagination__link pagination__link--prev">Previous</a>
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
</div> 