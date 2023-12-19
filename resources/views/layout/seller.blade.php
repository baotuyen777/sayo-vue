@include('layout.header')


<div class="container">
    @include('layout.common.breadcrumb')
    @yield('top-header')
    <div class="two-column">
        <div class="sidebar">
            @if (Auth::user())
                @include('layout.common.sidebar')
                <section class="white-box p-10 box-radius">
                    <h4>Quản lý</h4>
                    <p><a href="{{route('post.index')}}">Quản lý bài đăng</a></p>
                    <p><a href="{{route('product.index')}}">Quản lý sản phẩm</a></p>
                    @if(isAdmin())
                        <p><a href="{{route('user.index')}}">Quản lý user</a></p>
                    @endif
                    <p><a href="{{route('comment.index')}}">Quản lý comment</a></p>
                    <p><a href="{{route('order.index')}}">Quản lý đơn hàng</a></p>

                </section>
            @endif
        </div>
        <div class="main">
            @yield('content')
        </div>
    </div>


</div>


@include('layout.footer')
