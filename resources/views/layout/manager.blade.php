@include('layout.header')
<div class="container">
    <div class="sidebar">
        @include('component.manager.sidebar')
    </div>
    <div class="main">
        @yield('content')
    </div>

</div>


@include('layout.footer')
