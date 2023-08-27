@extends('layout.index')
@section('content')
    <div id="__next">
        <progress hidden=""></progress>
        <div class=" w1eil6in">
            <div class="b4hnkwj">
                <h1 class=" b13ldopu">
                    {{Route::is('login') ? 'Đăng Nhập' : 'Đăng ký tài khoản'}}
                </h1>

                <form method="post" class="mocked-styled-13 fei2bp7">
                    @if(Route::is('register'))
                        @include('component.form.input',['name'=> 'name', 'label' => 'Họ và tên'])
                        @include('component.form.input',['name'=> 'email', 'label' => 'Email', 'inputmode' =>'email', 'type' =>'email'])
                    @endif

                    @include('component.form.input',['name'=> 'phone', 'label' => 'Số điện thoại', 'inputmode' =>'numeric', 'type' =>'tel'])
                    @include('component.form.input',['name'=> 'password', 'label' => 'Mật khẩu',  'type' =>'password'])

                    <a class="forgot-password-btn" href="forget-password">Quên mật khẩu?</a>
                    <button class="bns1dlc primary large w-bold i-left stretch">
                        {{Route::is('login') ? '   ĐĂNG NHẬP' : 'ĐĂNG KÝ'}}
                    </button>
                    @csrf
                </form>

                <div class="mocked-styled-16 a1k9ogns">
                    <hr/>
                    <span>Hoặc đăng nhập bằng</span>
                    <hr/>
                </div>
                <div class="">

                    <div class="mocked-styled-15 g15384yj">
                        <button class="mocked-styled-18 b10u9umr">
                            <svg width="21" height="20" viewBox="0 0 21 20" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M19.2992 10.1951C19.2992 9.47569 19.2395 8.95069 19.1102 8.40625H10.7031V11.6534H15.6379C15.5384 12.4604 15.0012 13.6757 13.8072 14.4923L13.7905 14.601L16.4487 16.6133L16.6328 16.6312C18.3242 15.1048 19.2992 12.859 19.2992 10.1951Z"
                                    fill="#4285F4"></path>
                                <path
                                    d="M10.7042 18.75C13.1219 18.75 15.1515 17.9722 16.634 16.6306L13.8084 14.4916C13.0522 15.0069 12.0374 15.3666 10.7042 15.3666C8.33635 15.3666 6.32663 13.8403 5.61022 11.7306L5.50522 11.7393L2.74122 13.8296L2.70508 13.9278C4.17754 16.7861 7.2021 18.75 10.7042 18.75Z"
                                    fill="#34A853"></path>
                                <path
                                    d="M5.61025 11.7322C5.42122 11.1878 5.31182 10.6044 5.31182 10.0016C5.31182 9.39881 5.42122 8.8155 5.6003 8.27106L5.59529 8.15511L2.79666 6.03125L2.7051 6.07381C2.09823 7.25994 1.75 8.59191 1.75 10.0016C1.75 11.4113 2.09823 12.7432 2.7051 13.9294L5.61025 11.7322Z"
                                    fill="#FBBC05"></path>
                                <path
                                    d="M10.7042 4.63331C12.3856 4.63331 13.5198 5.34303 14.1665 5.93612L16.6936 3.525C15.1416 2.11528 13.1219 1.25 10.7042 1.25C7.2021 1.25 4.17754 3.21387 2.70508 6.07218L5.60028 8.26944C6.32664 6.15972 8.33636 4.63331 10.7042 4.63331Z"
                                    fill="#EB4335"></path>
                            </svg>
                            Google
                        </button>
                        <div id="google-login-btn"></div>
                    </div>
                </div>
                @if(Route::is('login'))
                    <p class="mocked-styled-33 rnv45ui">Chưa có tài khoản? <a href="register">Đăng ký tài khoản mới</a>
                    </p>
                @else
                    <p class="mocked-styled-33 rnv45ui">Đã có tài khoản? <a href="login">Đăng nhập ngay</a></p>
                @endif

            </div>
        </div>
    </div>
@endsection
