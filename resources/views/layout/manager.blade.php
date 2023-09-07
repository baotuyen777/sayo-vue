@include('layout.header')
<div class="container ">
    @include('component.common.breadcrumb')
    <div class="two-column">
        <div class="sidebar">
            @include('layout.sidebar')
        </div>
        <div class="main">
            @yield('content')
        </div>
    </div>


</div>


@include('layout.footer')
