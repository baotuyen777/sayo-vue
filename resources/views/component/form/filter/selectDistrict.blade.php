@php
    $url_components = parse_url(url()->full());
    $urlParams=[];
    if(isset($url_components['query']))
        parse_str($url_components['query'], $urlParams);
@endphp
<div class="form-control1 ">
    <div class="dropdown">
        <button class="dropdown__button" type="button">
            <i class="location"></i>
            <span>{{$district['name'] ?? 'Tất cả huyện'}}</span>
        </button>
        <div class="dropdown__body scroll">
            <div>
                <ul>
                    <li><a href="{{route('archive',array_merge($urlParams,['catCode' =>$category['code'],'provinceCode' => $province['code']]))}}"
                           data-id="0"><span>{{$first?? 'Tất cả'}}</span><img
                                src="https://static.chotot.com/storage/chotot-icons/svg/grey-next.svg"></a></li>
                    @foreach($options as $i=>$option)

                        <li>
                            <a
                                href="{{route('archive',array_merge(['catCode'=>$category['code'],'provinceCode' => $province['code'],'districtCode'=>$option['code']], $urlParams))}}"
                               data-id="{{$option['id'] ?? $i}}"><span>{{$option['name'] ?? $option}}</span><i
                                    class="next"></i></a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>


</div>
