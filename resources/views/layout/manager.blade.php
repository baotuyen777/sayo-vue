@include('layout.header')
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
                        {{ $user->name }}
                        <svg viewBox="0 0 12 13" width="16" height="16" fill="currentColor"
                            title="Tài khoản đã xác minh"
                            class="icon-vertify-account {{ $user->status > 1 ? '' : 'not-vertify' }}">
                            <g fill-rule="evenodd" transform="translate(-98 -917)">
                                <path
                                    d="m106.853 922.354-3.5 3.5a.499.499 0 0 1-.706 0l-1.5-1.5a.5.5 0 1 1 .706-.708l1.147 1.147 3.147-3.147a.5.5 0 1 1 .706.708m3.078 2.295-.589-1.149.588-1.15a.633.633 0 0 0-.219-.82l-1.085-.7-.065-1.287a.627.627 0 0 0-.6-.603l-1.29-.066-.703-1.087a.636.636 0 0 0-.82-.217l-1.148.588-1.15-.588a.631.631 0 0 0-.82.22l-.701 1.085-1.289.065a.626.626 0 0 0-.6.6l-.066 1.29-1.088.702a.634.634 0 0 0-.216.82l.588 1.149-.588 1.15a.632.632 0 0 0 .219.819l1.085.701.065 1.286c.014.33.274.59.6.604l1.29.065.703 1.088c.177.27.53.362.82.216l1.148-.588 1.15.589a.629.629 0 0 0 .82-.22l.701-1.085 1.286-.064a.627.627 0 0 0 .604-.601l.065-1.29 1.088-.703a.633.633 0 0 0 .216-.819">
                                </path>
                            </g>
                        </svg>
                        <small class="hide">Chưa có đánh giá</small>
                    </h1>
                    <p class="d-flex gap-10">
                        <a href="#">Người theo dõi: <b>1</b></a>
                        <a href="#">Đang theo dõi: <b>0</b></a>
                    </p>
                    <div class="edit-profile">
                        @if (isset($user['id']) && Auth::user()->id === $user['id'])
                            <a class="btn btn--primary " href="{{ route('profile') }}">Chỉnh sửa</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="detail-infor">
                <div class="d-flex gap-10 label-chat">
                    <div class="mr-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M3.644 4.392a.15.15 0 01.106-.044h12a.15.15 0 01.15.15v8.25a.15.15 0 01-.15.15H6.712a.6.6 0 00-.377.134L3.6 15.242V4.498a.15.15 0 01.044-.106zM6.9 14.118l-3.523 2.847a.6.6 0 01-.977-.467v-12a1.35 1.35 0 011.35-1.35h12a1.35 1.35 0 011.35 1.35v3.15h3.15a1.35 1.35 0 011.35 1.35v12a.6.6 0 01-.977.467l-3.548-2.867H8.25a1.35 1.35 0 01-1.35-1.35v-3.13zm10.2-5.27h3.15a.15.15 0 01.15.15v10.744l-2.735-2.21a.6.6 0 00-.378-.134H8.25a.15.15 0 01-.15-.15v-3.15h7.65a1.35 1.35 0 001.35-1.35v-3.9zM6.8 7.23c0-.276.192-.5.428-.5h5.143c.237 0 .429.224.429.5 0 .277-.192.5-.429.5H7.228c-.236 0-.428-.223-.428-.5zm.428 2.5c-.236 0-.428.224-.428.5 0 .277.192.5.428.5h5.143c.237 0 .429-.223.429-.5 0-.276-.192-.5-.429-.5H7.228z"
                                clip-rule="evenodd">
                            </path>
                        </svg>
                        <span>Phản hồi chat:</span>
                    </div>
                    <div>72% (Trong 18 hours)</div>
                </div>
                <div class="d-flex gap-10 label-time">
                    <div class="mr-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 25" aria-hidden="true" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M4.5 5.377a1.55 1.55 0 00-1.55 1.55v13.5c0 .856.694 1.55 1.55 1.55h15a1.55 1.55 0 001.55-1.55v-13.5a1.55 1.55 0 00-1.55-1.55h-15zm-2.95 1.55a2.95 2.95 0 012.95-2.95h15a2.95 2.95 0 012.95 2.95v13.5a2.95 2.95 0 01-2.95 2.95h-15a2.95 2.95 0 01-2.95-2.95v-13.5z"
                                clip-rule="evenodd">
                            </path>
                            <path
                                d="M13.875 12.926a1.125 1.125 0 100-2.25 1.125 1.125 0 000 2.25zM17.625 12.926a1.125 1.125 0 100-2.25 1.125 1.125 0 000 2.25zM13.875 16.676a1.125 1.125 0 100-2.25 1.125 1.125 0 000 2.25zM17.625 16.676a1.125 1.125 0 100-2.25 1.125 1.125 0 000 2.25zM6.375 16.676a1.125 1.125 0 100-2.25 1.125 1.125 0 000 2.25zM10.125 16.676a1.125 1.125 0 100-2.25 1.125 1.125 0 000 2.25zM6.375 20.426a1.125 1.125 0 100-2.25 1.125 1.125 0 000 2.25zM10.125 20.426a1.125 1.125 0 100-2.25 1.125 1.125 0 000 2.25zM13.875 20.426a1.125 1.125 0 100-2.25 1.125 1.125 0 000 2.25z">
                            </path>
                            <path fill-rule="evenodd"
                                d="M6 2.477a.7.7 0 01.7.7v1.5a.7.7 0 11-1.4 0v-1.5a.7.7 0 01.7-.7zm12 0a.7.7 0 01.7.7v1.5a.7.7 0 11-1.4 0v-1.5a.7.7 0 01.7-.7zM2.25 7.727h19.5v1.4H2.25v-1.4z"
                                clip-rule="evenodd">
                            </path>
                        </svg>
                        <span>Đã tham gia:</span>
                    </div>
                    <div>{{ showHumanTime($user->created_at ?? '') }}</div>
                </div>
                <div class="d-flex gap-10 label-address">
                    <div class="mr-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" fill="currentColor">
                            <g fill-rule="evenodd" clip-path="url(#clip0_8440_50966)" clip-rule="evenodd">
                                <path
                                    d="M12 7.45a2.3 2.3 0 100 4.6 2.3 2.3 0 000-4.6zm-3.7 2.3a3.7 3.7 0 117.4 0 3.7 3.7 0 01-7.4 0z">
                                </path>
                                <path
                                    d="M12 2.95a6.8 6.8 0 00-6.8 6.8c0 3.124 1.743 5.963 3.578 8.073A23.683 23.683 0 0012 20.877a23.672 23.672 0 003.222-3.054c1.835-2.11 3.578-4.95 3.578-8.072a6.8 6.8 0 00-6.8-6.8zm0 18.8l-.402.574-.002-.002-.006-.003-.019-.014a19.876 19.876 0 01-.319-.237 25.097 25.097 0 01-3.53-3.327C5.807 16.54 3.8 13.378 3.8 9.751a8.2 8.2 0 0116.4 0c0 3.627-2.007 6.788-3.922 8.99a25.095 25.095 0 01-3.53 3.327 14.959 14.959 0 01-.32.237l-.019.014-.005.003-.002.002L12 21.75zm0 0l.401.574a.7.7 0 01-.803 0L12 21.75z">
                                </path>
                            </g>
                            <defs>
                                <clipPath id="clip0_8440_50966">
                                    <path d="M0 0h24v24H0z"></path>
                                </clipPath>
                            </defs>
                        </svg>
                        <span>Địa chỉ: </span>
                    </div>
                    <div>
                        {{ getFullAddress($user)}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    @include('layout.common.breadcrumb')
    <div class="two-column">
        <div class="sidebar">
            @if (Auth::user())
                @include('layout.common.sidebar')
            @endif
        </div>
        <div class="main">
            @yield('content')
        </div>
    </div>


</div>


@include('layout.footer')
