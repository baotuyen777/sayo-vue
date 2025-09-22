<?php

namespace App\Livewire;

use App\Models\PostComment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Comment extends Component
{
    public $content;
    public $item_id;
    public $parent_id = null;
    public $comments;
    public $obj;

    protected $rules = [
        'content' => 'required|min:3',
        'item_id' => 'required',
    ];

    protected $messages = [
        'content.required' => 'Vui lòng nhập nội dung bình luận',
        'content.min' => 'Nội dung bình luận phải có ít nhất 3 ký tự',
    ];

    public function mount($obj)
    {
        $this->obj = $obj;
        $this->item_id = $obj->id;
        $this->loadComments();
    }

    public function loadComments()
    {
        $this->comments = $this->obj->comments;
    }

    public function store()
    {
        if (!Auth::check()) {
            session()->flash('error', 'Bạn cần đăng nhập để có thể bình luận');
            return;
        }

        $this->validate();

        try {
            PostComment::create([
                'content' => $this->content,
                'item_id' => $this->item_id,
                'user_id' => Auth::id(),
                'parent_id' => $this->parent_id,
            ]);

            $this->content = '';
            $this->parent_id = null;
            $this->loadComments();
            session()->flash('success', 'Bình luận đã được gửi thành công');
        } catch (\Exception $e) {
            session()->flash('error', 'Đã có lỗi xảy ra vui lòng thử lại');
        }
    }

    public function reply($commentId)
    {
        if (!Auth::check()) {
            session()->flash('error', 'Bạn cần đăng nhập để có thể trả lời bình luận');
            return;
        }
        $this->parent_id = $commentId;
    }

    public function render()
    {
        return view('livewire.comment');
    }
}
