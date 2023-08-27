{{--<div class="form-control @error($name) error @enderror">--}}
{{--    <input class="ire0wc " name="{{$name}}" type="{{$type ?? 'text'}}"--}}
{{--           inputmode="{{$inputmode ?? 'text'}}" value="{{ old($name) }}">--}}
{{--    <label for="{{$name}}">{{$label}}</label>--}}
{{--    <button tabindex="-1" type="button">--}}
{{--        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 12" width="1em" height="1em" fill="none">--}}
{{--            <g fill="none" fill-rule="evenodd">--}}
{{--                <circle fill="#8C8C8C" cx="6" cy="6" r="6"></circle>--}}
{{--                <path d="M3.863 3.863l4.275 4.275m-.001-4.275L3.862 8.138" stroke="#FFF" stroke-linecap="round"--}}
{{--                      stroke-linejoin="round" stroke-width="1.6"></path>--}}
{{--            </g>--}}
{{--        </svg>--}}
{{--    </button>--}}
{{--    @error($name)--}}
{{--    <p class="mocked-styled-10 p1scu4lb">{{ $message }}</p>--}}
{{--    @enderror--}}
{{--</div>--}}

<div class="  @error($name) error @enderror">

    <label class="withLabel primary s1mexxby">
        <input  type="checkbox"
            value=""><span class="checkbox"></span>{{$label}}</label>
    @error($name)
    <p class="mocked-styled-10 p1scu4lb">{{ $message }}</p>
    @enderror
</div>
