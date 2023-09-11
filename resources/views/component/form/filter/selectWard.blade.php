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
            <span>{{$ward['name'] ?? 'Tất cả phường'}}</span>
        </button>
        <div class="dropdown__body scroll">
            <div>

                <ul>
                    <li>
                        <a href="{{route('archive',array_merge(['catCode' =>$category['code'],'provinceCode'=>$province['code'],'districtCode'=>$district['code']], $urlParams))}}"
                           data-id="0"><span>{{$first?? 'Tất cả'}}</span><img
                                src="https://static.chotot.com/storage/chotot-icons/svg/grey-next.svg"></a></li>
                    @foreach($options as $i=>$option)

                        <li><a href="{{route('archive',array_merge(['catCode'=>$category['code'],'provinceCode'=>$province['code'],
'districtCode'=>$district['code'], 'wardCode' => $option['code']], $urlParams))}}"
                               data-id="{{$option['id'] ?? $i}}"><span>{{$option['name'] ?? $option}}</span><i
                                    class="next"></i></a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>


</div>
