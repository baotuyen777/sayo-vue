<!doctype html>
<html lang="vi">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <meta name="viewport" content="width=device-width">
    <meta charset="utf-8">
    <link rel="canonical" href="<?php echo env('APP_URL') ?>">
    <title>Sayo - Website Mua Bán, Rao Vặt Trực Tuyến Hàng Đầu Của Người Việt</title>
    <meta property="og:image" content="https://sayo.vn/img/sayo-default-vertical.webp">
    <meta property="og:url" content="https://sayo.vn">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Sayo - Website Mua Bán, Rao Vặt Trực Tuyến Hàng Đầu Của Người Việt">
    <meta property="og:description"
          content="Sayo - Website mua bán rao vặt của người Việt với hàng ngàn món hời đang được rao bán mỗi ngày. Đăng tin mua bán UY TÍN, NHANH CHÓNG, AN TOÀN.">
    <link rel="stylesheet" href="{{env('APP_URL')}}/css/main.css" type="text/css">
    {{--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">--}}
{{--    <script src='https://icybernet.vn/wp-includes/js/jquery/jquery.min.js?ver=3.6.1' id='jquery-core-js'></script>--}}
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
</head>
<body>
@include('layout.header')
@yield('content')
@if(session('success'))
    <div class="notify">
        {{ session('success') }}
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
@include('layout.footer')
<script src='{{ env('APP_URL')}}/js/toatstr.min.js'></script>
<script src='{{ env('APP_URL')}}/js/main.js'></script>
</body>
</html>
