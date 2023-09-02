<footer class="white-box">
    <div class="mocked-styled-21 l1j2xuoh">
        <a href="{{getPageUrl('gioi-thieu')}}" target="_blank">Giới thiệu</a><span>•</span>
        <a href="{{getPageUrl('gioi-thieu')}}" target="_blank">Quy chế hoạt động sàn</a><span>•</span>
        <a href="{{getPageUrl('gioi-thieu')}}" target="_blank">Chính sách bảo mật</a><span>•</span>
        <a href="{{getPageUrl('gioi-thieu')}}" target="_blank">Liên hệ hỗ trợ</a>
    </div>

    {{--    <section class="container">--}}
    {{--        <div class="d-flex grid-3">--}}

    {{--            <div class=""><p>Về SAYO</p>--}}
    {{--                <ul>--}}
    {{--                    <li><a href="{{getPageUrl('gioi-thieu')}}">Giới thiệu</a></li>--}}
    {{--                    <li><a>Quy chế hoạt động sàn</a></li>--}}
    {{--                    <li><a>Chính sách bảo mật</a></li>--}}
    {{--                    <li><a>Giải quyết tranh chấp</a></li>--}}
    {{--                    <li><a href="https://careers.sayo.vn">Tuyển dụng</a></li>--}}

    {{--                </ul>--}}
    {{--            </div>--}}

    {{--        </div>--}}
    {{--    </section>--}}

</footer>
@if(session('notify'))
    <div class="notify {{session('notify_type') ?? ''}}">
        {{ session('notify') }}
        <button tabindex="-1" type="button">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 12" width="1em" height="1em" fill="none">
                <g fill="none" fill-rule="evenodd">
                    <circle fill="#8C8C8C" cx="6" cy="6" r="6"></circle>
                    <path d="M3.863 3.863l4.275 4.275m-.001-4.275L3.862 8.138" stroke="#FFF" stroke-linecap="round"
                          stroke-linejoin="round" stroke-width="1.6"></path>
                </g>
            </svg>
        </button>
    </div>
@endif

<script src='{{ env('APP_URL')}}/js/toatstr.min.js'></script>
<script src='{{ env('APP_URL')}}/js/main.js'></script>

</body>
</html>
