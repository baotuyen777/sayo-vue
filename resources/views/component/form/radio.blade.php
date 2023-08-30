<div class="withSpan snf9jyk">
@php $defaultValue = $obj[$name] ?? 1; @endphp
    <div class="c14gw4h s6gb1av">
        <label class="required s1jyec19">{{$label}}</label>
        <div class="chip-wrapper">
            @foreach($options as $key =>$optionLabel)
                <button type="button" class="{{$defaultValue==$key ? 'active' : ''}} c14jmev1 s131j4vo" font-size="sm">
                    {{$optionLabel}}
                </button>
            @endforeach
            <input type="hidden" name="{{$name}}" value="{{$defaultValue}}">

        </div>

    </div>

</div>
{{--<div class="  @error($name) error @enderror">--}}

{{--    <label class="withLabel primary s1mexxby">--}}
{{--        <input  type="checkbox"--}}
{{--            value=""><span class="checkbox"></span>{{$label}}</label>--}}
{{--    @error($name)--}}
{{--    <p class="mocked-styled-10 p1scu4lb">{{ $message }}</p>--}}
{{--    @enderror--}}
{{--</div>--}}
