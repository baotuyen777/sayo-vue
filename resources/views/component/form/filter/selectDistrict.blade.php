
<div class="form-control1 ">
    <div class="dropdown">
        <button class="dropdown__button" type="button">
            <i class="location"></i>
            <span>{{$district['name'] ?? 'Tất cả huyện'}}</span>
        </button>
        <div class="dropdown__body scroll">
            <div>
                <ul>
                    <li><a href="{{route('archive',['catCode' =>$category['code'],'provinceCode' => $province['code']])}}"
                           data-id="0"><span>{{$first?? 'Tất cả'}}</span><img
                                src="https://static.chotot.com/storage/chotot-icons/svg/grey-next.svg"></a></li>
                    @foreach($options as $i=>$option)

                        <li>
                            <a
                                href="{{route('archive',['catCode'=>$category['code'],'provinceCode' => $province['code'],'districtCode'=>$option['code']])}}"
                               data-id="{{$option['id'] ?? $i}}"><span>{{$option['name'] ?? $option}}</span><i
                                    class="next"></i></a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>


</div>
