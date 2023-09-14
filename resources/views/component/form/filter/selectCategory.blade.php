@php
    $url_components = parse_url(url()->full());
    $urlParams=[];
    if(isset($url_components['query']))
        parse_str($url_components['query'], $urlParams);
    if(isset($category['code']))
        $urlParams['catCode'] =$category['code'];
@endphp

<div class="dropdown">
    <button class="dropdown__button" type="button">
        <i class="sitemap"></i>
        <span>{{$province['name'] ?? 'Tất cả các danh mục'}}</span>
    </button>
    <div class="dropdown__content ">
        <div class="head">
            <h4>Chọn danh mục</h4>
            <button class="dropdown__close" type="button"><i class="close"></i></button>

        </div>
        <div class="body scroll">
            <ul>
                <li><a href="{{route('archive',$urlParams)}}"
                       data-id="0"><i class="sitemap"></i><span>{{$first?? 'Tất cả'}}</span></a></li>
                @foreach($options as $i=>$option)
                    <li><a href="{{route('archive',array_merge(['provinceCode'=>$option['code']],$urlParams))}}"
                           data-id="{{$option['id'] ?? $i}}"><i class="{{$option['code']}}"></i><span>{{$option['name'] ?? $option}}</span>
                        </a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>


