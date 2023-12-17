<div class="form-control1 ">
    <div class="dropdown">
        <button class="btn dropdown__button" type="button">
            <i class="label-dollar"></i>
            @if(request()->get('price_from'))
                <span>{{'Từ '.moneyFormat(request()->get('price_from'))}}</span>
            @endif
            @if( request()->get('price_to'))
                <span>{{'đến '.moneyFormat(request()->get('price_to'))}}</span>
            @endif
            @if(!request()->get('price_from') && !request()->get('price_to'))
                <span>Giá</span>
            @endif
            @if(request()->get('price_from') || request()->get('price_to'))
                <i class="close clear"></i>
            @endif
        </button>
        <div class="dropdown__content">
            <div class="head">
                <h4>Chọn khoảng giá</h4>
                <button class="dropdown__close" type="button"><i class="close"></i></button>

            </div>
            <div class="body">
                <div class="range">
                    <div class="range__body">
                        <input class="" type="number" placeholder="₫ TỪ" name="price_from" step="1000"
                               value="{{request()->get('price_from') ?? ''}}">
                        <span class="line"></span>
                        <input type="number" placeholder="₫ ĐẾN" name="price_to" step="1000"
                               value="{{request()->get('price_to') ?? ''}}">
                    </div>
                    <button class="btn--primary full no-radius">Áp dụng</button>
                </div>
            </div>


        </div>
    </div>


</div>
