<div class="account-menu">
    @guest

        <a href="{{ route('login') }}">Đăng nhập</a>
    @endguest
    @auth
            <div class="avatar">
                <img class="aw__is4v2dl aw__i1408gg0 aw__uevk1au"
                     src="{{ asset('img/icon/default_user.png')}}" alt="Sayo">
                <span class="no-wrap">{{ Auth::user()->name }}</span>
                <svg width="1rem" height="1rem" viewBox="0 0 16 16" fill="none"
                     xmlns="http://www.w3.org/2000/svg" class="aw__dvoj89e">
                    <path
                        d="M4.67154 5.99959C4.9323 5.74067 5.35336 5.74141 5.6132 6.00125L8.19653 8.58458L10.7863 6.00048C11.0461 5.74125 11.4668 5.74148 11.7263 6.00099C11.986 6.26071 11.986 6.68179 11.7263 6.94151L8.90364 9.76414C8.51312 10.1547 7.87995 10.1547 7.48943 9.76414L4.66987 6.94459C4.40872 6.68344 4.40947 6.25981 4.67154 5.99959Z"
                        fill="currentColor"></path>
                </svg>
            </div>
    @endauth



    @include('layout.common.account-menu-content')
</div>
