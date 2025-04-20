<div>
    <div class="header">
        <div class="container">
            <div class="header__backdrop">
                <img src="{{ asset('img/banner/9555d3ff737c0f48c390ff5426c382f8-2840158350697184195.png') }}"
                     alt="user-backdrop">
            </div>
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <div class="header__profile">
                <div class="group__infor">
                    <div class="avatar">
                        <div class="border-avatar">
                            <img alt="Avatar" src="{{ asset('img/icon/default_user.png') }}">
                        </div>
                    </div>
                    <div class="infor">
                        <h1>
                            {{ $shop->name ?? ''}}
                            <svg viewBox="0 0 12 13" width="16" height="16" fill="currentColor"
                                 title="Tài khoản đã xác minh"
                                 class="icon-vertify-account {{ $shop->status??0 > 1 ? '' : 'not-vertify' }}">
                                <g fill-rule="evenodd" transform="translate(-98 -917)">
                                    <path
                                        d="m106.853 922.354-3.5 3.5a.499.499 0 0 1-.706 0l-1.5-1.5a.5.5 0 1 1 .706-.708l1.147 1.147 3.147-3.147a.5.5 0 1 1 .706.708m3.078 2.295-.589-1.149.588-1.15a.633.633 0 0 0-.219-.82l-1.085-.7-.065-1.287a.627.627 0 0 0-.6-.603l-1.29-.066-.703-1.087a.636.636 0 0 0-.82-.217l-1.148.588-1.15-.588a.631.631 0 0 0-.82.22l-.701 1.085-1.289.065a.626.626 0 0 0-.6.6l-.066 1.29-1.088.702a.634.634 0 0 0-.216.82l.588 1.149-.588 1.15a.632.632 0 0 0 .219.819l1.085.701.065 1.286c.014.33.274.59.6.604l1.29.065.703 1.088c.177.27.53.362.82.216l1.148-.588 1.15.589a.629.629 0 0 0 .82-.22l.701-1.085 1.286-.064a.627.627 0 0 0 .604-.601l.065-1.29 1.088-.703a.633.633 0 0 0 .216-.819">
                                    </path>
                                </g>
                            </svg>
                            <small class="hide">Chưa có đánh giá</small>
                        </h1>
                        <div class="d-flex gap-10 label-address">
                            <div>
                                <img src="{{asset('img/icon/icon_location.svg')}}" height="14">
                                {{ getFullAddress($shop??'')}}
                            </div>
                        </div>
                        <div class="edit-profile">
                            @if (isset($shop['id']) && isset(Auth::user()->id) === $shop['id'])
                                <a class="btn btn--primary " href="{{ route('profile') }}">Chỉnh sửa</a>
                            @endif


                        </div>
                    </div>
                </div>
                <div class="detail-infor">
                    <p class="d-flex gap-10">
                        <a href="#">Người theo dõi: <b>1</b></a>
                        <a href="#">Đang theo dõi: <b>0</b></a>
                    </p>

                    <div class="btn mt-1 btn-like-page {{ $isLike ? 'btn--primary' : 'btn--gray' }}">
                        <span @class('d-flex align-items-center gap-2')>
                             <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" id="like-icon"
                                  xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M15.9 4.5C15.9 3 14.418 2 13.26 2c-.806 0-.869.612-.993 1.82-.055.53-.121 1.174-.267 1.93-.386 2.002-1.72 4.56-2.996 5.325V17C9 19.25 9.75 20 13 20h3.773c2.176 0 2.703-1.433 2.899-1.964l.013-.036c.114-.306.358-.547.638-.82.31-.306.664-.653.927-1.18.311-.623.27-1.177.233-1.67-.023-.299-.044-.575.017-.83.064-.27.146-.475.225-.671.143-.356.275-.686.275-1.329 0-1.5-.748-2.498-2.315-2.498H15.5S15.9 6 15.9 4.5zM5.5 10A1.5 1.5 0 0 0 4 11.5v7a1.5 1.5 0 0 0 3 0v-7A1.5 1.5 0 0 0 5.5 10z"
                            />
                            </svg>
                            <span>{{ $isLike ? 'Đã thích' : 'Thích trang' }}</span>
                        </span>

                        <input type="hidden" name="seller_id" value="{{ $shop['id'] }}">
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="sidebar-content">
        <section @class('card')>
            <h2>Giới thiệu</h2>
            <div class="card__body">
                @if (isset($shop['id']) && isset(Auth::user()->id) && Auth::user()->id === $shop['id'])
                    <div class="bio-form">
                        @if ($successMessage)
                            <div class="alert alert-success">
                                {{ $successMessage }}
                            </div>
                        @endif
                        
                        @if (session()->has('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        
                        <textarea wire:model="bio" class="bio-editor"></textarea>
                        <div class="bio-actions">
                            <button type="button" wire:click="updateBio" class="btn btn-sm btn--primary">Lưu</button>
                        </div>
                    </div>
                @else
                    {{$shop->bio??''}}
                @endif
            </div>
            <h2>Danh mục</h2>
            <ul class="shop-categories">
                @forelse($shopCategories as $category)
                    <li>
                        <a href="{{ route('archive', ['catCode' => $category->code, 'author_id' => $shop['id']]) }}">
                            {{ $category->name }}
                        </a>
                    </li>
                @empty
                    <li class="no-categories">Shop chưa có danh mục sản phẩm nào</li>
                @endforelse
            </ul>
        </section>
    </div>

    <div class="main-content">
        <section class="portfolio__tab">
            @php
                $tabs = [
                    'products' => 'Sản phẩm',
                    'posts' => 'Tin vặt',
                    'reviews' => 'Đánh giá'
                ];
            @endphp

            @foreach($tabs as $key => $label)
                <div
                    class="children_menu {{ $key === 'products' ? 'activelink' : '' }}"
                    title="{{ ucfirst($key) }}"
                    data-tab="{{ $key }}-tab">
                    <span>{{ $label }}</span>
                </div>
            @endforeach
        </section>
        
        <div class="list-data" id="products-tab">
            @include('component.form.filter.index')
            <div class="d-flex-wrap grid-4 ">
                @foreach($products as $product)
                    @include('component.product.product_card',['obj' => $product])
                @endforeach
            </div>
            @if(method_exists($products, 'links'))
            <div class="pagination">
                @if ($products->onFirstPage())
                    <span class="pagination__link pagination__link--prev pagination__link--disabled">Trang đầu</span>
                @else
                    <a href="{{ $products->previousPageUrl() }}" class="pagination__link pagination__link--prev">Trang trước</a>
                @endif

                @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                    @if ($page == $products->currentPage())
                        <span class="pagination__link pagination__link--active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="pagination__link">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() }}" class="pagination__link pagination__link--next">Trang sau</a>
                @else
                    <span class="pagination__link pagination__link--next pagination__link--disabled">Trang sau</span>
                @endif
            </div>
            @endif
        </div>

        <div class="list-data hide-tab" id="posts-tab">
            <div class="d-flex-wrap grid-4">
                @forelse($posts as $post)
                                    @include('component.post.post_card',['obj' => $post])
                @empty
                    <div class="notice-empty">
                        <p>Chưa có tin vặt nào</p>
                    </div>
                @endforelse
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
        </div>

        <div class="d-flex-wrap grid-2 list-data hide-tab" id="reviews-tab">
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
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        .bio-editor {
            width: 100%;
            min-height: 100px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            resize: vertical;
            margin-bottom: 10px;
        }
        
        .bio-actions {
            text-align: right;
        }
        
        .btn-sm {
            padding: 4px 10px;
            font-size: 14px;
        }
        
        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        
        .alert-success {
            background-color: #dff0d8;
            border-color: #d6e9c6;
            color: #3c763d;
        }
        
        .alert-danger {
            background-color: #f2dede;
            border-color: #ebccd1;
            color: #a94442;
        }

        .sidebar-content {
            float: left;
            width: 25%;
            padding-right: 20px;
        }

        .main-content {
            float: left;
            width: 75%;
            min-height: 500px;
        }
        
        .shop-categories {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .shop-categories li {
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .shop-categories li:last-child {
            border-bottom: none;
        }
        
        .shop-categories a {
            color: #333;
            text-decoration: none;
            display: block;
            transition: color 0.2s ease;
        }
        
        .shop-categories a:hover {
            color: #007bff;
        }
        
        .shop-categories .no-categories {
            color: #999;
            font-style: italic;
        }

        @media (max-width: 768px) {
            .sidebar-content, .main-content {
                float: none;
                width: 100%;
                padding-right: 0;
            }
            
            .main-content {
                min-height: 400px;
            }
        }
    </style>
</div>
