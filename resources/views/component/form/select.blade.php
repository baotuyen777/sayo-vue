<div class="form-control form-control-{{$name}}  @error($name) error @enderror">
    <select class="select ihj19gg isDropdown hasValue required" name="{{$name}}">
        <option value=""></option>

        @foreach($options as $k => $option)
            <option
                {{isset($obj) && $k == $obj[$name] ||(
                         isset($obj['attr'])
                         && isset($attr)
                         && isset($obj['attr']->$attr)
                         &&  $obj['attr']->$attr == $k
                    )
                 ? 'selected' : ''
                 }}
                value="{{$option['id'] ?? $k}}">{{$option['name'] ?? $option}}</option>
        @endforeach
    </select>
    <label for="{{$name}}">{{$label}}</label>
    <svg data-type="monochrome"
         xmlns="http://www.w3.org/2000/svg"
         viewBox="0 0 512 512" width="1em" height="1em"
         fill="none" class="arrow">
        <path
            d="M7.9 156.8l2.8 3.3 214.8 247.2c7.3 8.4 18.2 13.6 30.3 13.6 12.2 0 23.1-5.4 30.3-13.6l214.7-246.7 3.6-4.1c2.7-3.9 4.3-8.7 4.3-13.7 0-13.7-11.7-25-26.2-25h-453c-14.5 0-26.2 11.2-26.2 25 0 5.2 1.7 10.1 4.6 14z"
            fill="currentColor"></path>
    </svg>

    <p class="helptext "></p>
    @error($name)
    <p class="mocked-styled-10 ">{{ $message }}</p>
    <p>{{ $message }}</p>
    @enderror
    <p class="validate validate-{{$name}}"></p>
    <p class="helptext p131urh5"></p>
</div>


