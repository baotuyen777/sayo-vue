{{--<!-- resources/views/components/layouts/app.blade.php -->--}}
{{--<!DOCTYPE html>--}}
{{--<html lang="vi">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1.0">--}}
{{--    <title>My App</title>--}}
{{--    @livewireStyles--}}
{{--</head>--}}
{{--<body>--}}
{{--{{ $slot }}  --}}{{-- Nội dung của từng page --}}

{{--@livewireScripts--}}
{{--</body>--}}
{{--</html>--}}
@include('layout.header')
<main>
    @include('layout.common.breadcrumb')
{{--    @yield('content')--}}
    {{ $slot }}
</main>

@include('layout.footer')
