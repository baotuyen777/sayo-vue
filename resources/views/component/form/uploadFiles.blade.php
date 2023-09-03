<div class="upload-files">
    <input type="file" name="files[]" id="files" accept="image/*" multiple class="hide"/>

    <div class="preview">
        @if(isset($obj['files']))
            @foreach($obj['files'] as $file)
                <img src="{{$file['url']}}">
            @endforeach

        @endif
    </div>
    <button class="btn btn-primary btn_addfile" type="button">
        <i class="fa fa-picture-o" aria-hidden="true"></i> Thêm ảnh
    </button>

</div>
<script>
    state.media_ids ={{$obj['media_ids']}}
</script>
