<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    {{--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">--}}
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
<script src='https://icybernet.vn/wp-includes/js/jquery/jquery.min.js?ver=3.6.1' id='jquery-core-js'></script>
<script src='{{ env('APP_URL')}}/js/toatstr.min.js'></script>
<script src='{{ env('APP_URL')}}/js/main.js'></script>
</body>
</html>
