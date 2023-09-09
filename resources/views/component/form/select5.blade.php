<div class="form-control1 ">
    <div class="select5">
        <button class="select5__button">
            <i></i>
            <span>Hà Nội</span>
        </button>
        <div class="select5__body">
            {{--            <div class="styles_headerCustom__WFf0U">--}}
            {{--                <button type="button" class="close"><span aria-hidden="true">×</span></button>--}}
            {{--                <h4 class="text-center styles_titleCustom__nikjG "> Chọn vị trí</h4></div>--}}
            <div>

                <ul>
                    <li><a href="#"><span>Toàn quốc</span><img
                                src="https://static.chotot.com/storage/chotot-icons/svg/grey-next.svg"
                            ></a></li>
                    @foreach($provinces as $province)

                        <li><a href="#"><span>{{$province['name']}}</span><i class="next"></i></a></li>
                    @endforeach
                </ul>

            </div>
        </div>
    </div>


</div>
