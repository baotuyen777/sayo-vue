    <div class=" form-textarea form-control form-control-{{$name}}">
        <div class="focus-capture"></div>
        <textarea class="required sodjbf4" inputmode="text"
                  id="field-{{$name}}" name="{{$name}}" placeholder="{{$placeholder}}">{{$obj[$name] ?? ''}}</textarea>
        <label for="field-{{$name}}">Mô tả chi tiết</label>
        <p class="validate validate-{{$name}}"></p>
    </div>

{{--    <p class="poe54zc">Vui lòng nhập ít nhất 10 từ</p>--}}
{{--<div class="wfq6gk9" style="--wfq6gk9-0: -12px;"><span--}}
{{--        data-testid="test-length">0</span><span>/</span><span--}}
{{--        data-testid="test-max">1500</span><span> kí tự</span>--}}
{{--</div>--}}
