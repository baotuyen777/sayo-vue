<div class="comment form-control form-control-{{$name}}">
    <textarea class="required comment__content" inputmode="text"
              id="field-{{$name}}" name="{{$name}}" placeholder="{{$placeholder}}">{{$obj[$name] ?? ''}}</textarea>
    <label for="field-{{$name}}">{{$label ?? ''}}</label>
    <p class="validate validate-{{$name}}"></p>
</div>
