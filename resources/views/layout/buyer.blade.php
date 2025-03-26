@include('layout.header')

<div class="container">
{{--    @include('layout.common.breadcrumb')--}}
    @yield('top-header')
    {{--    <div class="two-column">--}}
    {{--        <div class="sidebar">--}}
    {{--            @if (isLoged())--}}
    {{--                @include('layout.common.sidebar')--}}
    {{--            @endif--}}
    {{--            @if((Auth::check() && Auth::user()->id === $user->id) || isAdmin())--}}
    {{--                <section class="white-box p-10 box-radius">--}}
    {{--                    <h4>Hồ sơ xin việc</h4>--}}
    {{--                    <p>Chưa tạo hồ sơ xin việc nào!</p>--}}

    {{--                    <button class="btn">Tạo hồ sơ xin việc--}}
    {{--                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true"--}}
    {{--                             fill="currentColor">--}}
    {{--                            <path--}}
    {{--                                d="M9.292 17.288a1 1 0 01.003-1.413L13.17 12 9.294 8.115a.998.998 0 011.411-1.41l4.588 4.588a1 1 0 010 1.414L10.71 17.29a1 1 0 01-1.418-.002z"></path>--}}
    {{--                        </svg>--}}
    {{--                    </button>--}}

    {{--                </section>--}}
    {{--            @endif--}}

    {{--        </div>--}}
    <div class="main">
        <div class="d-flex">
            <aside @class('flex-25')>
                @yield('sidebar')
            </aside>
            <div style="flex: 1;" @class('flex-1')>
                @yield('content')
            </div>
        </div>

    </div>
    {{--    </div>--}}


</div>


@include('layout.footer')
