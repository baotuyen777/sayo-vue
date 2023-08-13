<div class="card card--product">
    <a target="_blank" href="">
        <div class="avatar"
             style="background: url({{$obj['avatar']['url'] ?? asset('img/sayo-default-vertical.webp')}})"></div>
    </a>
    <div class="product__caption">
        <a target="_blank" href="#" class="card__title">{{$obj['name']}}</a>
        {{--        <div class="product__feedback">--}}
        {{--            <div>--}}
        {{--                <button type="button" aria-haspopup="true" aria-expanded="false">--}}
        {{--                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"--}}
        {{--                         xmlns="http://www.w3.org/2000/svg">--}}
        {{--                        <circle cx="8" cy="2" r="2" transform="rotate(90 8 2)"--}}
        {{--                                fill="#222222"></circle>--}}
        {{--                        <circle cx="8" cy="8" r="2" transform="rotate(90 8 8)"--}}
        {{--                                fill="#222222"></circle>--}}
        {{--                        <circle cx="8" cy="14" r="2" transform="rotate(90 8 14)"--}}
        {{--                                fill="#222222"></circle>--}}
        {{--                    </svg>--}}
        {{--                </button>--}}

        {{--            </div>--}}
        {{--        </div>--}}
{{--        <div class="card__extra-attr text-gray">--}}
{{--            <div class="">20 m² - 2 PN</div>--}}
{{--        </div>--}}
        <div><span class="card__price">{{moneyFormat($obj['price'])}}</span></div>
    </div>
    <div class="card__footer text-small text-gray">
        <img height="16"
             src="https://static.chotot.com/storage/chotot-icons/svg/user.svg"
             alt="{{$obj['author']['name'] ?? 'sayo'}}">
        <span>Hà Nội- hôm qua</span>
    </div>
</div>
