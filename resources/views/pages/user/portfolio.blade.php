@extends('layout.buyer')
@section('top-header')
    <div class="header">
        <div class="container">
            <div class="header__backdrop">
                <img src="{{ asset('img/banner/9555d3ff737c0f48c390ff5426c382f8-2840158350697184195.png') }}"
                     alt="user-backdrop">
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
                            {{ $user->name ?? ''}}
                            <svg viewBox="0 0 12 13" width="16" height="16" fill="currentColor"
                                 title="Tài khoản đã xác minh"
                                 class="icon-vertify-account {{ $user->status??0 > 1 ? '' : 'not-vertify' }}">
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
                                {{ getFullAddress($user??'')}}
                            </div>
                        </div>
                        <div class="edit-profile">
                            @if (isset($user['id']) && isset(Auth::user()->id) === $user['id'])
                                <a class="btn btn--primary " href="{{ route('profile') }}">Chỉnh sửa</a>
                            @endif
                            <div class="btn mt-1 btn-like-page {{ $isLike ? 'btn--primary' : 'btn--gray' }}">
                                <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" id="like-icon"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M15.9 4.5C15.9 3 14.418 2 13.26 2c-.806 0-.869.612-.993 1.82-.055.53-.121 1.174-.267 1.93-.386 2.002-1.72 4.56-2.996 5.325V17C9 19.25 9.75 20 13 20h3.773c2.176 0 2.703-1.433 2.899-1.964l.013-.036c.114-.306.358-.547.638-.82.31-.306.664-.653.927-1.18.311-.623.27-1.177.233-1.67-.023-.299-.044-.575.017-.83.064-.27.146-.475.225-.671.143-.356.275-.686.275-1.329 0-1.5-.748-2.498-2.315-2.498H15.5S15.9 6 15.9 4.5zM5.5 10A1.5 1.5 0 0 0 4 11.5v7a1.5 1.5 0 0 0 3 0v-7A1.5 1.5 0 0 0 5.5 10z"
                                    />
                                </svg>
                                <span>{{ $isLike ? 'Đã thích' : 'Thích trang' }}</span>
                                <form action="{{ route('user-like.store') }}" method="post" id="formLikePage">
                                    @csrf
                                    <input type="hidden" name="seller_id" value="{{ $user['id'] }}">
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="detail-infor">
{{--                                    <div class="d-flex gap-10 label-chat">--}}
{{--                                        <div class="mr-1">--}}
{{--                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" fill="currentColor">--}}
{{--                                                <path fill-rule="evenodd"--}}
{{--                                                    d="M3.644 4.392a.15.15 0 01.106-.044h12a.15.15 0 01.15.15v8.25a.15.15 0 01-.15.15H6.712a.6.6 0 00-.377.134L3.6 15.242V4.498a.15.15 0 01.044-.106zM6.9 14.118l-3.523 2.847a.6.6 0 01-.977-.467v-12a1.35 1.35 0 011.35-1.35h12a1.35 1.35 0 011.35 1.35v3.15h3.15a1.35 1.35 0 011.35 1.35v12a.6.6 0 01-.977.467l-3.548-2.867H8.25a1.35 1.35 0 01-1.35-1.35v-3.13zm10.2-5.27h3.15a.15.15 0 01.15.15v10.744l-2.735-2.21a.6.6 0 00-.378-.134H8.25a.15.15 0 01-.15-.15v-3.15h7.65a1.35 1.35 0 001.35-1.35v-3.9zM6.8 7.23c0-.276.192-.5.428-.5h5.143c.237 0 .429.224.429.5 0 .277-.192.5-.429.5H7.228c-.236 0-.428-.223-.428-.5zm.428 2.5c-.236 0-.428.224-.428.5 0 .277.192.5.428.5h5.143c.237 0 .429-.223.429-.5 0-.276-.192-.5-.429-.5H7.228z"--}}
{{--                                                    clip-rule="evenodd">--}}
{{--                                                </path>--}}
{{--                                            </svg>--}}
{{--                                            <span>Phản hồi chat:</span>--}}
{{--                                        </div>--}}
{{--                                        <div>72% (Trong 18 hours)</div>--}}
{{--                                    </div>--}}
{{--                                    <div class="d-flex gap-10 label-time">--}}
{{--                                        <div class="mr-1">--}}
{{--                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 25" aria-hidden="true" fill="currentColor">--}}
{{--                                                <path fill-rule="evenodd"--}}
{{--                                                    d="M4.5 5.377a1.55 1.55 0 00-1.55 1.55v13.5c0 .856.694 1.55 1.55 1.55h15a1.55 1.55 0 001.55-1.55v-13.5a1.55 1.55 0 00-1.55-1.55h-15zm-2.95 1.55a2.95 2.95 0 012.95-2.95h15a2.95 2.95 0 012.95 2.95v13.5a2.95 2.95 0 01-2.95 2.95h-15a2.95 2.95 0 01-2.95-2.95v-13.5z"--}}
{{--                                                    clip-rule="evenodd">--}}
{{--                                                </path>--}}
{{--                                                <path--}}
{{--                                                    d="M13.875 12.926a1.125 1.125 0 100-2.25 1.125 1.125 0 000 2.25zM17.625 12.926a1.125 1.125 0 100-2.25 1.125 1.125 0 000 2.25zM13.875 16.676a1.125 1.125 0 100-2.25 1.125 1.125 0 000 2.25zM17.625 16.676a1.125 1.125 0 100-2.25 1.125 1.125 0 000 2.25zM6.375 16.676a1.125 1.125 0 100-2.25 1.125 1.125 0 000 2.25zM10.125 16.676a1.125 1.125 0 100-2.25 1.125 1.125 0 000 2.25zM6.375 20.426a1.125 1.125 0 100-2.25 1.125 1.125 0 000 2.25zM10.125 20.426a1.125 1.125 0 100-2.25 1.125 1.125 0 000 2.25zM13.875 20.426a1.125 1.125 0 100-2.25 1.125 1.125 0 000 2.25z">--}}
{{--                                                </path>--}}
{{--                                                <path fill-rule="evenodd"--}}
{{--                                                    d="M6 2.477a.7.7 0 01.7.7v1.5a.7.7 0 11-1.4 0v-1.5a.7.7 0 01.7-.7zm12 0a.7.7 0 01.7.7v1.5a.7.7 0 11-1.4 0v-1.5a.7.7 0 01.7-.7zM2.25 7.727h19.5v1.4H2.25v-1.4z"--}}
{{--                                                    clip-rule="evenodd">--}}
{{--                                                </path>--}}
{{--                                            </svg>--}}
{{--                                            <span>Đã tham gia:</span>--}}
{{--                                        </div>--}}
{{--                                        <div>{{ showHumanTime($user->created_at ?? '') }}</div>--}}
{{--                                    </div>--}}
                    <p class="d-flex gap-10">
                        <a href="#">Người theo dõi: <b>1</b></a>
                        <a href="#">Đang theo dõi: <b>0</b></a>
                    </p>

                </div>
            </div>
            @if (Request::routeIs('user.show'))
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
            @endif

        </div>
    </div>
@endsection
@section('sidebar')
    <section @class('card')>
        <h2>Giới thiệu</h2>
        <div class="card__body ">{{$user->bio??''}}
        </div>
    </section>
@endsection
@section('content')

    <div class="list-data" id="products-tab">
        <div class="d-flex-wrap grid-4 ">
            @foreach($products as $product)
                @include('component.product.product_card',['obj' => $product])
            @endforeach
        </div>
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
