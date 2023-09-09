@include('layout.header')
<div class="container ">
    @include('layout.common.breadcrumb')
    <div class="two-column">
        <div class="sidebar">
            @include('layout.common.sidebar')
        </div>
        <div class="main">
            @yield('content')
        </div>
    </div>


</div>


@include('layout.footer')
