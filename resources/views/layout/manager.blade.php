@include('layout.header')


<div class="container">
    @include('layout.common.breadcrumb')
    @yield('top-header')
    <div class="two-column">
        <div class="sidebar">
            @if (Auth::user())
                @include('layout.common.sidebar')
            @endif
        </div>
        <div class="main">
            @yield('content')
        </div>
    </div>


</div>


@include('layout.footer')
