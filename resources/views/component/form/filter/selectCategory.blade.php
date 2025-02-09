@php
    $url_components = parse_url(url()->full());
    $urlParams=[];
    if(isset($url_components['query']))
        parse_str($url_components['query'], $urlParams);

    if( request('provinceCode'))
        $urlParams['provinceCode'] =   request('provinceCode');
    if( request('districtCode'))
         $urlParams['districtCode'] = request('districtCode');

    $urlParams['catCode'] ='tat-ca';
    $urlClear = route($route ?? 'archive', $urlParams);
@endphp

<div class="dropdown">
    <button class="btn dropdown__button" type="button">
        <i class="sitemap"></i>
        <span>{{$category['name'] ?? 'Tất cả danh mục'}}</span>
        @if(isset($category['name']))
            <a href="{{$urlClear}}" class="clear-link"><i class="close clear"></i></a>
        @endif
    </button>
    <div class="dropdown__content ">
        <div class="head">
            <h4>Chọn danh mục</h4>
            <button class="dropdown__close" type="button"><i class="close"></i></button>
        </div>
        <div class="body scroll">
            <ul>
                <li><a href="{{$urlClear}}"
                       data-id="0"><i class="sitemap"></i><span>{{$first?? 'Tất cả'}}</span></a></li>
                @foreach($options as $i=>$option)
                    <li><a href="{{route($route ?? 'archive',array_merge($urlParams,['catCode'=>$option['code']]))}}"
                           data-id="{{$option['id'] ?? $i}}"><i
                                class="{{$option['code']}}"></i><span>{{$option['name'] ?? $option}}</span>
                        </a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
<style>
    .clear-link {
        color: white;
        transition: opacity 0.2s ease;
    }

    .clear-link:hover {
        opacity: 0.8;
    }

    .clear-link .close.clear {
        color: white;
    }


</style>


