<div class="form-control1 ">
    <div class="dropdown">
        <button class="dropdown__button" type="button">
            <i class="search"></i>
            @if(request()->get('s'))
                <span>{{request()->get('s')}}</span>
            @else
                <span>Từ khóa</span>
            @endif
        </button>
        <div class="dropdown__body">
            <div class="range">
                <div class="range__body">
                    <input class=""  placeholder="Tìm từ khóa" name="s"
                           value="{{request()->get('s') ?? ''}}">

                </div>
                <button class="btn--primary full no-radius">Áp dụng</button>
            </div>

        </div>
    </div>


</div>
