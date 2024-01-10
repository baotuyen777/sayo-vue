{{--@php--}}
{{--    $fileIds =[];--}}
{{--        if(isset($obj['files'])){--}}
{{--            $fileIds =  $obj['files']->pluck('id')->toArray();--}}
{{--        }--}}
{{--@endphp--}}
<div class="upload-files">
    <input type="file" name="files[]" class="input-files hide" accept="image/*" multiple/>
    <div class="field-id-wrap">
        @if(isset($obj['files']))
            @foreach($obj['files'] as $file)
                <input type="hidden" name="file_ids[]" value="{{($file['id'])}}"/>
            @endforeach
        @endif
    </div>

    <div class="preview">
        @if(isset($obj['files']))
            @foreach($obj['files'] as $file)
                <img src="{{asset('storage/'.$file['url'])}}">
            @endforeach

        @endif
    </div>
    <button class="btn btn-primary btn_addfile" type="button">
        <i class="fa fa-picture-o" aria-hidden="true"></i> Thêm ảnh
    </button>

</div>
<script>
    state.file_ids ={{$obj['file_ids'] ?? '[]'}}
</script>
