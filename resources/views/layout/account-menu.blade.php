<div class="account-menu">
    <div class="avatar">
        <img class="aw__is4v2dl aw__i1408gg0 aw__uevk1au"
             src="https://cdn.chotot.com/uac2/1047384" alt="Sayo">
        <span class="no-wrap">Tài khoản</span>
        <svg width="1rem" height="1rem" viewBox="0 0 16 16" fill="none"
             xmlns="http://www.w3.org/2000/svg" class="aw__dvoj89e">
            <path
                d="M4.67154 5.99959C4.9323 5.74067 5.35336 5.74141 5.6132 6.00125L8.19653 8.58458L10.7863 6.00048C11.0461 5.74125 11.4668 5.74148 11.7263 6.00099C11.986 6.26071 11.986 6.68179 11.7263 6.94151L8.90364 9.76414C8.51312 10.1547 7.87995 10.1547 7.48943 9.76414L4.66987 6.94459C4.40872 6.68344 4.40947 6.25981 4.67154 5.99959Z"
                fill="currentColor"></path>
        </svg>
    </div>

    <div class="menu">

        <div class="aw__ntc1674" style="--ntc1674-2: 72px;">
            <span class="aw__nrouw61" style="--nrouw61-3: 48px;"></span>
            @guest
                <a href="{{ route('login') }}"><span class="aw__n171wcvy">Đăng nhập / Đăng ký</span></a>
            @endguest
            @auth
                <a href="{{ route('profile') }}"><span class="aw__n171wcvy">{{ Auth::user()->name }}</span></a>
            @endauth
        </div>


        {{--                    <div class="aw__l1txzw95">--}}
        {{--                        <a class="aw__iys36jq"--}}
        {{--                                                 href=""--}}
        {{--                                                 target="_self" rel="noreferrer">--}}
        {{--                            <div ><img class="aw__i13p2z3b"--}}
        {{--                                                          src="https://static.chotot.com/storage/icons/svg/setting.svg"--}}
        {{--                                                          alt="Cài đặt tài khoản"></div>--}}
        {{--                            <div >Cài đặt tài khoản</div>--}}
        {{--                        </a>--}}
        {{--                    </div>--}}
        <div class="aw__d15qd39x">Quản lí tin</div>
        <div class="aw__l1txzw95">
            <a class="aw__iys36jq" href="#">
                <img class="aw__i13p2z3b"
                     src="https://static.chotot.com/storage/chotot-icons/svg/escrow_buy_orders.svg"
                     alt="Lịch sử mua">
                <span>Quản lý đơn hàng</span>

            </a></div>
        <div class="aw__l1txzw95">
            <a class="aw__iys36jq" href="#">
                <img class="aw__i13p2z3b"
                     src="https://static.chotot.com/storage/chotot-icons/svg/escrow-orders.svg"
                     alt="Đơn bán">
                <span>Quản lý cửa hàng</span>
            </a></div>
        <div class="aw__l1txzw95">
            <a class="aw__iys36jq " href="#">
                <img class="aw__i13p2z3b"
                     src="https://static.chotot.com/storage/chotot-icons/svg/escrow.svg"
                     alt="Ví bán hàng">
                <span>0 VND</span>
            </a>
        </div>
        @auth
            <div class="aw__d15qd39x">Tài khoản</div>
            <div class="aw__l1txzw95">
                <a class="aw__iys36jq " href="#">
                    <img class="aw__i13p2z3b"
                         src="https://static.chotot.com/storage/icons/svg/setting.svg"
                         alt="Ví bán hàng">
                    <span>Cài đặt tài khoản</span>
                </a>
            </div>
            <div class="aw__l1txzw95">
                <a class="aw__iys36jq " href="{{env('APP_URL')}}/logout">
                    <img class="aw__i13p2z3b"
                         src="https://static.chotot.com/storage/icons/svg/logout.svg"
                         alt="Ví bán hàng">
                    <span>Đăng xuất</span>
                </a>
            </div>
        @endauth
    </div>
</div>
