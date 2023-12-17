@php
    $url_components = parse_url(url()->full());
    $urlParams=[];
    if(isset($url_components['query']))
        parse_str($url_components['query'], $urlParams);

     $urlParams['catCode'] = request('catCode') ?? 'tat-ca';
     $urlParams['provinceCode'] = request('provinceCode') ;
     $urlParams['catCode'] = request('catCode') ?? 'tat-ca';

    $urlParams['provinceCode'] =  $province['code'];
@endphp
<div class="form-control1 ">
    <div class="dropdown">
        <button class="btn dropdown__button" type="button">
            <i class="location"></i>
            <span>{{$district['name'] ?? 'Tất cả huyện'}}</span>
        </button>
        <div class="dropdown__content ">
            <div class="head">
                <h4>Chọn quận/huyện</h4>
                <button class="dropdown__close" type="button"><i class="close"></i></button>

            </div>
            <div class="body scroll">
                <ul>
                    <li>
                        <a href="{{route($route ?? 'archive',$urlParams)}}"
                           data-id="0"><span>{{$first?? 'Tất cả'}}</span></a></li>
                    @foreach($options as $i=>$option)
                        <li>
                            <a
                                href="{{route($route ?? 'archive',array_merge($urlParams,['districtCode'=>$option['code']]))}}"
                                data-id="{{$option['id'] ?? $i}}"><span>{{$option['name'] ?? $option}}</span></a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>


</div>
