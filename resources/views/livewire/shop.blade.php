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
        <section >
            <div class="filter-block card">
                <h3><i class="fas fa-list-ul"></i> Danh mục</h3>
                <ul class="shop-categories">
                    @forelse($shopCategories as $category)
                        <li wire:key="category-{{ $category->id }}">
                            <a href="#" wire:click.prevent="filterByCategory({{ $category->id }}, '{{ $category->code }}')" class="{{ $cat == $category->code ? 'active-category' : '' }}">
                                {{ $category->name }}
                            </a>
                        </li>
                    @empty
                        <li class="no-categories">Shop chưa có danh mục sản phẩm nào</li>
                    @endforelse
                    @if($cat)
                        <li wire:key="clear-filter">
                            <a href="#" wire:click.prevent="clearCategoryFilter" class="clear-filter">
                                Xem tất cả
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

            <div class="filter-block card">
                <h3><i class="fas fa-tags"></i> Giá</h3>
                <div class="price-filter">
                    @if($priceFrom || $priceTo)
                        <div class="price-range-display">
                            @if($priceFrom && $priceTo)
                                <span>Từ {{ number_format($priceFrom, 0, ',', '.') }}₫ đến {{ number_format($priceTo, 0, ',', '.') }}₫</span>
                            @elseif($priceFrom)
                                <span>Từ {{ number_format($priceFrom, 0, ',', '.') }}₫</span>
                            @elseif($priceTo)
                                <span>Đến {{ number_format($priceTo, 0, ',', '.') }}₫</span>
                            @endif
                        </div>
                    @endif
                    <div class="price-slider-container">
                        <div class="price-slider">
                            <input type="range"
                                   wire:model.defer="priceFrom"
                                   min="0"
                                   max="10000000"
                                   step="100000"
                                   class="price-range-slider"
                                   id="priceFrom"
                                   value="{{ $priceFrom ?? 0 }}">
                            <input type="range"
                                   wire:model.defer="priceTo"
                                   min="0"
                                   max="10000000"
                                   step="100000"
                                   class="price-range-slider"
                                   id="priceTo"
                                   value="{{ $priceTo ?? 10000000 }}">
                        </div>
                        <div class="price-slider-values">
                            <span>{{ $priceFrom ? number_format($priceFrom, 0, ',', '.') . '₫' : '0₫' }}</span>
                            <span>{{ $priceTo ? number_format($priceTo, 0, ',', '.') . '₫' : '10.000.000₫' }}</span>
                        </div>
                    </div>
                    <div class="price-actions">
                        <button wire:click="updatePriceFilter" class="btn btn-sm btn--primary price-apply-btn">Áp dụng</button>
                        @if($priceFrom || $priceTo)
                            <button wire:click="clearPriceFilter" class="btn btn-sm btn--link clear-filter">Xóa</button>
                        @endif
                    </div>
                </div>
            </div>

            <div class="filter-block card">
                <h3><i class="fas fa-search"></i> Tìm kiếm</h3>
                <div class="keyword-search">
                    @if($keyword)
                        <div class="keyword-display">
                            <span>Tìm kiếm: "{{ $keyword }}"</span>
                        </div>
                    @endif
                    <div class="keyword-input-container">
                        <input type="text" wire:model.defer="keyword" placeholder="Nhập từ khóa..." class="keyword-input">
                    </div>
                    <div class="keyword-actions">
                        <button wire:click="updateKeywordSearch" class="btn btn-sm btn--primary keyword-search-btn">Tìm kiếm</button>
                        @if($keyword)
                            <button wire:click="clearKeywordSearch" class="btn btn-sm btn--link clear-filter">Xóa</button>
                        @endif
                    </div>
                </div>
            </div>
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

        {{-- Sort Bar --}}
        <div class="sort-bar">
            <span class="sort-label">Sắp xếp theo</span>
            <button class="sort-btn {{ $sortBy === 'popular' ? 'active' : '' }}" wire:click="setSort('popular')">Phổ Biến</button>
            <button class="sort-btn {{ $sortBy === 'newest' ? 'active' : '' }}" wire:click="setSort('newest')">Mới Nhất</button>
            <button class="sort-btn {{ $sortBy === 'bestseller' ? 'active' : '' }}" wire:click="setSort('bestseller')">Bán Chạy</button>
            <div class="sort-dropdown">
                <button class="sort-btn {{ $sortBy === 'price' ? 'active' : '' }}" id="sortPriceBtn">
                    Giá <i class="fas fa-chevron-down"></i>
                </button>
                <div class="sort-dropdown-content">
                    <a href="#" wire:click.prevent="setSort('price', 'asc')">Thấp đến cao</a>
                    <a href="#" wire:click.prevent="setSort('price', 'desc')">Cao đến thấp</a>
                </div>
            </div>
            <div class="sort-dropdown">
                <button class="sort-btn {{ $sortBy === 'name' ? 'active' : '' }}" id="sortNameBtn">
                    Tên <i class="fas fa-chevron-down"></i>
                </button>
                <div class="sort-dropdown-content">
                    <a href="#" wire:click.prevent="setSort('name', 'asc')">A - Z</a>
                    <a href="#" wire:click.prevent="setSort('name', 'desc')">Z - A</a>
                </div>
            </div>
        </div>

        <div class="list-data" id="products-tab" wire:loading.class="is-loading">
            <div class="loading-overlay" wire:loading>
                <div class="spinner"></div>
            </div>
            <div class="d-flex-wrap grid-4 " wire:key="products-grid">
                @if(count($products) > 0)
                    @foreach($products as $product)
                        @include('component.product.product_card',['obj' => $product])
                    @endforeach
                @else
                    <div class="notice-empty">
                        <p>Không tìm thấy sản phẩm nào</p>
                    </div>
                @endif
            </div>
            @if(method_exists($products, 'links'))
            <div class="pagination">
                {{ $products->appends(['cat' => $cat, 'priceFrom' => $priceFrom, 'priceTo' => $priceTo, 'keyword' => $keyword])->links() }}
            </div>
            @endif
        </div>

        <div class="list-data hide-tab" id="posts-tab" wire:loading.class="is-loading">
            <div class="loading-overlay" wire:loading>
                <div class="spinner"></div>
            </div>
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
                {{ $posts->links() }}
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

        .filter-block {
            padding: 20px;
            border-bottom: 1px solid #eee;
        }

        .filter-block:last-child {
            border-bottom: none;
        }

        .filter-block h3 {
            margin-bottom: 15px;
            font-size: 18px;
            font-weight: 600;
            color: #333;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-block h3 i {
            font-size: 17px;
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
            padding: 4px 0;
        }

        .shop-categories a:hover {
            color: #007bff;
        }

        .shop-categories .no-categories {
            color: #999;
            font-style: italic;
        }

        .shop-categories a.active-category {
            color: #007bff;
            font-weight: bold;
        }

        .shop-categories a.clear-filter {
            color: #dc3545;
            font-size: 0.9em;
        }

        .shop-categories a.clear-filter:hover {
            color: #c82333;
            text-decoration: underline;
        }

        .price-filter {
            margin-bottom: 0;
        }

        .price-range-display {
            background-color: #f8f9fa;
            padding: 8px 12px;
            border-radius: 4px;
            margin-bottom: 15px;
            font-size: 14px;
            color: #007bff;
        }

        .price-slider-container {
            padding: 20px 10px;
            margin-bottom: 15px;
        }

        .price-slider {
            position: relative;
            width: 100%;
            height: 5px;
            background: #ddd;
            border-radius: 5px;
            margin: 20px 0;
        }

        .price-range-slider {
            position: absolute;
            width: 100%;
            height: 5px;
            background: none;
            pointer-events: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }

        .price-range-slider::-webkit-slider-thumb {
            height: 20px;
            width: 20px;
            border-radius: 50%;
            background: #007bff;
            cursor: pointer;
            margin-top: -8px;
            pointer-events: auto;
            -webkit-appearance: none;
        }

        .price-range-slider::-moz-range-thumb {
            height: 20px;
            width: 20px;
            border-radius: 50%;
            background: #007bff;
            cursor: pointer;
            pointer-events: auto;
            -moz-appearance: none;
        }

        .price-slider-values {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            font-size: 14px;
            color: #666;
        }

        .price-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
        }

        .keyword-search {
            margin-bottom: 0;
        }

        .keyword-display {
            background-color: #f8f9fa;
            padding: 8px 12px;
            border-radius: 4px;
            margin-bottom: 15px;
            font-size: 14px;
            color: #007bff;
        }

        .keyword-input-container {
            margin-bottom: 15px;
        }

        .keyword-input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .keyword-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn--link {
            background: none;
            border: none;
            color: #dc3545;
            padding: 0;
            font-size: 14px;
            text-decoration: underline;
            cursor: pointer;
        }

        .btn--link:hover {
            color: #c82333;
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

        .is-loading {
            position: relative;
            min-height: 200px;
            opacity: 0.6;
        }

        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 10;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .sort-bar {
            display: flex;
            align-items: center;
            background: #f5f5f5;
            padding: 18px 24px 18px 24px;
            border-radius: 6px;
            margin-bottom: 18px;
            gap: 10px;
        }
        .sort-label {
            font-weight: 500;
            color: #888;
            margin-right: 10px;
        }
        .sort-btn {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 7px 18px;
            margin-right: 8px;
            font-size: 15px;
            color: #333;
            cursor: pointer;
            transition: background 0.2s, color 0.2s, border 0.2s;
        }
        .sort-btn.active, .sort-btn:hover {
            background: #ff7337;
            color: #fff;
            border-color: #ff7337;
        }
        .sort-dropdown {
            position: relative;
            display: inline-block;
        }
        .sort-dropdown-content {
            display: none;
            position: absolute;
            background: #fff;
            min-width: 140px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            z-index: 10;
            border-radius: 4px;
            overflow: hidden;
            top: 100%;
            left: 0;
        }
        .sort-dropdown:hover .sort-dropdown-content {
            display: block;
        }
        .sort-dropdown-content a {
            color: #333;
            padding: 10px 18px;
            text-decoration: none;
            display: block;
            font-size: 15px;
            transition: background 0.2s, color 0.2s;
        }
        .sort-dropdown-content a:hover {
            background: #ff7337;
            color: #fff;
        }
        .sort-btn i {
            margin-left: 6px;
            font-size: 13px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.children_menu');
            const tabContents = document.querySelectorAll('.list-data');

            tabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Remove activelink class from all tabs
                    tabs.forEach(t => t.classList.remove('activelink'));

                    // Add activelink class to clicked tab
                    this.classList.add('activelink');

                    // Hide all tab contents
                    tabContents.forEach(content => {
                        content.classList.add('hide-tab');
                    });

                    // Show the selected tab content
                    const tabId = this.getAttribute('data-tab');
                    document.getElementById(tabId).classList.remove('hide-tab');
                });
            });

            const priceFrom = document.getElementById('priceFrom');
            const priceTo = document.getElementById('priceTo');

            function updatePriceRange() {
                const from = parseInt(priceFrom.value);
                const to = parseInt(priceTo.value);

                if (from > to) {
                    const temp = from;
                    priceFrom.value = to;
                    priceTo.value = temp;
                }

                // Update the displayed values
                const fromDisplay = document.querySelector('.price-slider-values span:first-child');
                const toDisplay = document.querySelector('.price-slider-values span:last-child');

                fromDisplay.textContent = from ? from.toLocaleString('vi-VN') + '₫' : '0₫';
                toDisplay.textContent = to ? to.toLocaleString('vi-VN') + '₫' : '10.000.000₫';
            }

            // Set initial values if not set
            if (!priceFrom.value) priceFrom.value = 0;
            if (!priceTo.value) priceTo.value = 10000000;

            priceFrom.addEventListener('input', updatePriceRange);
            priceTo.addEventListener('input', updatePriceRange);
        });
    </script>
</div>
