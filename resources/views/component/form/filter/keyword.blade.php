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
        <div class="dropdown__content">
            <div class="head">
                <h4>Tìm theo từ khóa</h4>
                <button class="dropdown__close" type="button"><i class="close"></i></button>

            </div>
            <div class="body">
                <div class="range__body">
                    <input class=""  placeholder="Tìm từ khóa" name="s"
                           value="{{request()->get('s') ?? ''}}">

                </div>
                <button class="btn--primary full no-radius">Áp dụng</button>
            </div>

        </div>
    </div>


</div>
