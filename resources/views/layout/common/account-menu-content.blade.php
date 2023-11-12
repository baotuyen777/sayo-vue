<div class="menu-items">
    <div class="menu-user">
        @guest
            <span class="menu-avatar hide-xs"></span>
            <h3><a href="{{ route('login') }}">Đăng nhập</a>  <span class="hide-xs">/</span> <a
                    href="{{ route('register') }}">Đăng ký</a></h3>
        @endguest
        @auth
            <h3><a href="{{route('user.show',['user'=>Auth()->user()->username])}}">{{ Auth::user()->name }}</a></h3>
        @endauth
    </div>
    @auth
        <a href="#">
            <img src="{{asset('img/icon/icon_bag.svg')}}" alt="Lịch sử mua">
            <span>Quản lý đơn hàng</span>
        </a>
        @if(isAdmin())
            {{--            <a href="{{route('user.show',['user'=>Auth()->user()->username])}}">--}}
            <a href="{{route('post.index')}}">
                <img src="{{asset('img/icon/icon_bag.svg')}}" alt="Lịch sử mua">
                <span>Quản lý bài đăng</span>
            </a>
        @endif

        <a href="{{route('profile')}}">
            <img src={{asset('img/icon/icon_setting.svg')}} alt="setting">
            <span>Cài đặt tài khoản</span>
        </a>
        <a href="{{route('logout')}}">
            <img src="{{asset('img/icon/icon_logout.svg')}}" alt="logout">
            <span>Đăng xuất</span>
        </a>
    @endauth
</div>

