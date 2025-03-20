<?php

namespace App\Livewire\post;

use App\Models\Post;
use App\Services\Post\PostService;
use Livewire\Component;

class PostDetail extends Component
{
    public $code;
    private PostService $postsService;

    public function __construct()
    {
        $this->postsService = new PostService();
    }

    public function mount($code = null)
    {
        $this->code = $code ?? request()->route('code');
    }

    public function render()
    {
        $obj = Post::getOne($this->code, true, true);
//dd($obj->categories);
        if (!$obj) {
            return view('pages.404');
        }

        // Increment view number
        $this->postsService->incrementViewNumber($this->code);

        // Wrap the view content in a single root element
        return view('livewire.post.post-detail', ['obj' => $obj]);
    }
}
