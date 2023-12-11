<aside>
    {{--    <section class="white-box p-10 box-radius">--}}
    {{--        <h4>Hồ sơ xin việc</h4>--}}
    {{--        <p>Bạn chưa tạo hồ sơ xin việc nào!</p>--}}
    {{--        <div class="mocked-styled-38 b1btdmev">--}}
    {{--            <button class="btn">Tạo hồ sơ xin việc--}}
    {{--                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" fill="currentColor">--}}
    {{--                    <path--}}
    {{--                        d="M9.292 17.288a1 1 0 01.003-1.413L13.17 12 9.294 8.115a.998.998 0 011.411-1.41l4.588 4.588a1 1 0 010 1.414L10.71 17.29a1 1 0 01-1.418-.002z"></path>--}}
    {{--                </svg>--}}
    {{--            </button>--}}
    {{--        </div>--}}
    {{--    </section>--}}

    @if(Auth::user()->role===1)
        <section class="white-box p-10 box-radius">
            <h4>Quản lý</h4>
            <p><a href="{{route('post.index')}}">Quản lý bài đăng</a></p>
            <p><a href="{{route('product.index')}}">Quản lý sản phẩm</a></p>
            <p><a href="{{route('user.index')}}">Quản lý user</a></p>
            <p><a href="{{route('comment.index')}}">Quản lý comment</a></p>
            <p><a href="{{route('order.index')}}">Quản lý đơn hàng</a></p>

        </section>
    @endif
</aside>
