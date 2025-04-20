
@include('layout.header')
<main>
    @include('layout.common.breadcrumb')
    <div @class('d-flex container gap-5')>
        <!-- <aside @class('sidebar flex-20 ')>
            @yield('sidebar')
        </aside> -->
        <div @class('flex-1')>
            {{ $slot }}
        </div>
    </div>


</main>

@include('layout.footer')
