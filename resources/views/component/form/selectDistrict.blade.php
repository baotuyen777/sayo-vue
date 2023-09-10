
<div class="form-control1 ">
    <div class="select5">
        <button class="select5__button">
            <i></i>
            <span>{{$district['name'] ?? 'Tất cả huyện'}}</span>
        </button>
        <div class="select5__body">
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
