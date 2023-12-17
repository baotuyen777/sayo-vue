<div class="form-control1 form-control-{{$name}}  @error($name) error @enderror">

    <label class="withLabel primary s-checkbox">
        <input  type="checkbox"
            value=""><span class="checkbox"></span>{{$label}}</label>
    @error($name)
    <p>{{ $message }}</p>
    @enderror
</div>
