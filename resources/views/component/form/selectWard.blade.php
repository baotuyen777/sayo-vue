<div class="form-control1 ">
    <div class="select5">
        <button class="select5__button">
            <i></i>
            <span>{{$ward['name'] ?? 'Tất cả phường'}}</span>
        </button>
        <div class="select5__body">
            <div>

                <ul>
                    <li>
                        <a href="{{route('archive',['catCode' =>$category['code'],'provinceCode'=>$province['code'],'districtCode'=>$district['code']])}}"
                           data-id="0"><span>{{$first?? 'Tất cả'}}</span><img
                                src="https://static.chotot.com/storage/chotot-icons/svg/grey-next.svg"></a></li>
                    @foreach($options as $i=>$option)

                        <li><a href="{{route('archive',['catCode'=>$category['code'],'provinceCode'=>$province['code'],
'districtCode'=>$district['code'], 'wardCode' => $option['code']])}}"
                               data-id="{{$option['id'] ?? $i}}"><span>{{$option['name'] ?? $option}}</span><i
                                    class="next"></i></a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>


</div>
