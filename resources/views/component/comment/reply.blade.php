<!-- Reply form start -->
<form action="{{ route('comment.store') }}" class="form__comment-ajax reply-form" method="POST" id="reply-form-{{$id}}">
{{--    <button--}}
{{--        class="btn btn-sm btn-default btn-hover-primary"--}}
{{--        data-toggle="reply-form"--}}
{{--        data-target="comment-{{$id}}-reply-form">Bình--}}
{{--        luận--}}
{{--    </button>--}}
    @csrf
    <input type="hidden" name="item_id" value="{{ $item_id }}">
    <input type="hidden" name="parent_id" value="{{ $parent_id }}">
    <textarea name="content" placeholder=" Trả lời bình luận" rows="4" ></textarea>
    <button type="submit" class="btn btn-sm btn-submit">
        Gửi
    </button>

</form>
<!-- Reply form end -->
