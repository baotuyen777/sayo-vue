<!-- Reply form start -->
<form action="{{ route('comment.store') }}" class="form__comment-ajax reply-form d-none" method="POST" id="comment-{{$id}}-reply-form">
    @csrf
    <input type="hidden" name="item_id" value="{{ $item_id }}">
    <input type="hidden" name="parent_id" value="{{ $parent_id }}">
    <textarea name="content" placeholder=" Trả lời bình luận" rows="4" style="padding: 2px;"></textarea>
    <button type="submit" class="btn btn-sm btn-warning pull-left" style="margin-right: 2px;">
        Gửi
    </button>
    <button type="button" data-toggle="reply-form" class="btn btn-sm btn-warning pull-left"
            data-target="comment-{{ $id }}-reply-form">Hủy bỏ
    </button>
</form>
<!-- Reply form end -->
