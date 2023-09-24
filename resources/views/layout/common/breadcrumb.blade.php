@php
    $breadcrumbs = [
        'home' => 'Trang chủ',
    ];
@endphp
@if(\Request::route()->getName() != 'home')
    <div class="container">
        <ol class="breadcrumb">
            @foreach($breadcrumbs as $k=> $label)
                <li><a href="{{route($k)}}">{{$label}}</a></li>
            @endforeach
            <li class="BreadCrumb_breadcrumbItem__M8Q4i" itemprop="itemListElement">
                <span>{{$pageName??$obj['name'] ?? 'Danh sách'}}</span>
            </li>

        </ol>

    </div>
@endif
