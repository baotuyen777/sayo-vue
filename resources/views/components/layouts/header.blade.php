<!doctype html>
<html lang="vi">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <meta name="viewport" content="width=device-width">
    <meta charset="utf-8">
    <link rel="canonical" href="<?php echo asset('') ?>">
    <title>{{$title ?? 'Sayo - Website Mua Bán, Rao Vặt Trực Tuyến Hàng Đầu Của Người Việt}}</title>
    <meta property="og:image" content="https://sayo.vn/img/sayo-default-vertical.webp">
    <meta property="og:url" content="https://sayo.vn">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Sayo - Website Mua Bán, Rao Vặt Trực Tuyến Hàng Đầu Của Người Việt">
    <meta property="og:description"
          content="Sayo - Website mua bán rao vặt của người Việt với hàng ngàn món hời đang được rao bán mỗi ngày. Đăng tin mua bán UY TÍN, NHANH CHÓNG, AN TOÀN.">
    <link rel="icon" href="/favicon.ico" sizes="32x32"/>
    <link rel="stylesheet" href="{{asset('')}}/css/main.css" type="text/css">
    {{--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">--}}
    {{--    <script src='https://icybernet.vn/wp-includes/js/jquery/jquery.min.js?ver=3.6.1' id='jquery-core-js'></script>--}}
    <script src="{{env('PRODUCTION')?'https://code.jquery.com': asset('').'/js/libs/'}}/jquery-1.12.4.min.js"
            integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ"
            crossorigin="anonymous"></script>
    <script type="text/javascript"
            src="{{!env('PRODUCTION')?'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js': asset('').'/js'}}"
            crossorigin="anonymous"></script>
    <script>
        var state = {};
    </script>
    @stack('css')
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1249489300078063"
            crossorigin="anonymous"></script>
    @livewireStyles
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<header class="main-header">
    <div class="container">
        <nav class="main-nav">
            <div class="logo">
                <a href="{{ route('home')}}">
                    <img src="{{ asset('') }}/img/logo-white.png" alt="sayo-logo"></a></div>
            <div class="search-form-wrapper">
                <form class="search-form" action="{{route('archive')}}">
                    <input autocomplete="off" name="s" placeholder="Tìm kiếm sản phẩm - Dịch vụ trên Sayo"
                           class="aw__t16o28i7" value="{{request()->get('s') ?? ''}}">
                    <button class="btn btn--primary">
                        <svg xmlns="http://www.w3.org/2000/svg" data-type="monochrome"
                             viewBox="0 0 16 16" width="1em" height="1em" fill="none">
                            <path fill="currentColor"
                                  d="M6.4 0a6.369 6.369 0 00-4.525 1.873A6.425 6.425 0 00.502 3.906v.002A6.383 6.383 0 000 6.398a6.372 6.372 0 001.875 4.524 6.385 6.385 0 008.428.537l-.006.006 4.295 4.293a.827.827 0 001.166-1.166l-4.295-4.295a6.368 6.368 0 00-.537-8.424A6.372 6.372 0 006.4 0zm0 1.615a4.75 4.75 0 013.383 1.4c.44.44.785.95 1.028 1.522h-.002c.249.59.377 1.214.377 1.861 0 .648-.128 1.27-.377 1.862h.002a4.783 4.783 0 01-2.55 2.545c-.59.25-1.213.377-1.86.377a4.761 4.761 0 01-1.864-.377A4.749 4.749 0 013.016 9.78c-.44-.44-.783-.95-1.024-1.521a4.735 4.735 0 01-.377-1.862c0-.647.127-1.272.377-1.863a4.75 4.75 0 011.024-1.52 4.754 4.754 0 013.384-1.4z"></path>
                        </svg>
                    </button>
                </form>
            </div>
            <div class="nav-quick-button hide-xs">
                <a class="btn btn--primary btn--large"
                   href="{{route('publicPost')}}" rel="nofollow">Đăng tin</a>
                @include('layout.common.account-menu')
            </div>

            <div class="menu-mobile hide-pc">
                <input type="checkbox"/>
                <span></span>
                <span></span>
                <span></span>
                <div class="content">
                    @include('layout.common.account-menu-content')
                    <a class="btn btn--primary btn--large"
                       href="{{route('publicPost')}}" rel="nofollow">Đăng tin</a>
                </div>
            </div>
        </nav>

        <ul class="nav hide-xs">
            <li class="active">
                <a href="{{route('archive')}}"> DANH MỤC</a>
                <ul class="sub-menu">
                    @foreach(getCategories() as $code=>$name)
                        <li><a href="{{route('archive',['catCode'=>$code])}}">{{$name}}</a></li>
                    @endforeach
                </ul>

            </li>
{{--            <li><a href="{{route('hotgirl')}}">Hot girl</a></li>--}}
        </ul>
    </div>
</header>
