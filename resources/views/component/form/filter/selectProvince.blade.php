@php
    $url_components = parse_url(url()->full());
    $urlParams=[];
    if(isset($url_components['query']))
        parse_str($url_components['query'], $urlParams);

    $urlParams['catCode'] = request('catCode') ?? 'tat-ca';
@endphp
<div class="form-control1 ">
    <div class="dropdown">
        <button class="dropdown__button" type="button">
            <i class="location"></i>
            {{--            <i class="close"></i>--}}
            <span>{{$province['name'] ?? 'Toàn quốc'}}</span>
        </button>
        <div class="dropdown__content ">
            <div class="head">
                <h4>Chọn tỉnh/thành phố</h4>
                <button class="dropdown__close" type="button"><i class="close"></i></button>
            </div>
            <div class="body scroll">
                <ul>
                    <li><a href="{{route('archive',$urlParams)}}"
                           data-id="0"><span>{{$first?? 'Tất cả'}}</span></a></li>
                    @foreach($options as $i=>$option)
                        <li><a href="{{route('archive',array_merge(['provinceCode'=>$option['code']],$urlParams))}}"
                               data-id="{{$option['id'] ?? $i}}"><span>{{$option['name'] ?? $option}}</span><i
                                    class="next"></i></a></li>
                    @endforeach
                </ul>
            </div>

        </div>


    </div>


</div>
