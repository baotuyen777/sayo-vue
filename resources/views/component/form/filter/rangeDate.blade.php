<div class="form-control1 ">
    <div class="dropdown">
        <button class="btn dropdown__button" type="button">
            <i class="label-time"></i>
            @if(request()->get('date_from'))
                <span>{{'Từ '.request()->get('date_from')}}</span>
            @endif
            @if( request()->get('date_to'))
                <span>{{'đến '.request()->get('date_to')}}</span>
            @endif
            @if(!request()->get('date_from') && !request()->get('date_to'))
                    <span>Thời gian</span>
            @endif
            @if(request()->get('date_from') || request()->get('date_to'))
                <i class="close clear"></i>
            @endif
        </button>
        <div class="dropdown__content">
            <div class="head">
                <h4>Chọn thời gian</h4>
                <button class="dropdown__close" type="button"><i class="close"></i></button>

            </div>
            <div class="body">
                <div class="range">
                    <div class="range__body">
                        <span>TỪ:</span>
                        <input class="" type="date" placeholder="TỪ" name="date_from"
                               value="{{request()->get('date_from') ?? ''}}">
                        <span class="line"></span>
                        <span>ĐẾN:</span>
                        <input type="date" placeholder="ĐẾN" name="date_to"
                               value="{{request()->get('date_to') ?? ''}}">
                    </div>
                    <button class="btn--primary full no-radius">Áp dụng</button>
                </div>
            </div>


        </div>
    </div>


</div>
