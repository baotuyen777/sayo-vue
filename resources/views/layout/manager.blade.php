@include('layout.header')
<div class="container two-column">
    <div class="sidebar">
        @include('layout.sidebar')
    </div>
    <div class="main">
        @yield('content')
    </div>

</div>


@include('layout.footer')
