<footer class="p-10">
    <div class="d-flex justify-content-center gap-10">
        <a href="{{route('pageView',['code'=>'gioi-thieu'])}}" target="_blank">Giới thiệu</a><span>•</span>
        <a href="{{route('pageView',['code'=>'gioi-thieu'])}}" target="_blank">Quy chế hoạt động sàn</a><span>•</span>
        <a href="{{route('pageView',['code'=>'gioi-thieu'])}}" target="_blank">Chính sách bảo mật</a><span>•</span>
        <a href="{{route('pageView',['code'=>'gioi-thieu'])}}" target="_blank">Liên hệ hỗ trợ</a>
    </div>
</footer>
<div class="notify {{session('notify_type') ?"notify--".session('notify_type'): ''}}"
     style="display: {{session('notify') ? 'block' : 'none'}}">
    <span class="content">{{ session('notify') }}</span>
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

<div class="overlay">
    <div class="loader"></div>
</div>
<div id="blackout" class="blackout"></div>

<div id="dusktext"></div>

<script src='{{ env('APP_URL')}}/js/main.js'></script>

@stack('js')
{{--@if(env('APP_ENV')=='production')--}}
{{--    @include('layout.common.social')--}}
{{--@endif--}}

</body>
</html>

