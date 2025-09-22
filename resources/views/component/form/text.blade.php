<div class="form-control form-control-{{$name}} @error($name) error @enderror">
    <input class="minput  " name="{{$name}}" type="{{$type ?? 'text'}}" placeholder="{{$placeholder ??''}}"
           inputmode="{{$inputmode ?? 'text'}}" wire:model="obj.{{$name}}" value="{{ $obj[$name] ?? old($name) }}" maxlength="{{$maxleng ??'' }}">
    <label for="{{$name}}">{{$label}}</label>
    @if(!isset($type) || in_array($type,['text']))
        <button tabindex="-1" type="button" class="btn-close">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 12" width="1em" height="1em" fill="none">
                <g fill="none" fill-rule="evenodd">
                    <circle fill="#8C8C8C" cx="6" cy="6" r="6"></circle>
                    <path d="M3.863 3.863l4.275 4.275m-.001-4.275L3.862 8.138" stroke="#FFF" stroke-linecap="round"
                          stroke-linejoin="round" stroke-width="1.6"></path>
                </g>
            </svg>
        </button>
    @endif
    @error('obj.'.$name)
    <p>{{ $message }}</p>
    @enderror
    <p class="validate validate-{{$name}}"></p>
</div>
