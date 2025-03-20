<?php

namespace App\Livewire\post;

use App\Models\Post;
use App\Services\Post\PostService;
use Livewire\Component;
use Livewire\WithPagination;

class PostComponent extends Component
{
    public $posts, $title, $content, $post_id;
    public $isEdit = false;

    use WithPagination;

    public $category;
    public $keyword;

    protected $queryString = [
        'category' => ['except' => ''],
        'keyword' => ['except' => ''],
    ];
    protected $postsService;

    public function __construct()
    {
        $this->postsService = new PostService();
    }

    public function mount()
    {
        $this->posts = Post::all();
    }

//    public function show($id)
//    {
//        $this->selectedPost = Post::findOrFail($id);
////        $post = Post::findOrFail($id);
////        return view('livewire.post-detail', ['post' => $post]);
//    }

    public function list()
    {
        $this->posts = Post::all();
    }

    public function create()
    {
        Post::create([
            'title' => $this->title,
            'content' => $this->content,
        ]);

        $this->reset(['title', 'content']);
        $this->posts = Post::all();
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $this->post_id = $post->id;
        $this->title = $post->title;
        $this->content = $post->content;
        $this->isEdit = true;
    }

    public function update()
    {
        $post = Post::findOrFail($this->post_id);
        $post->update([
            'title' => $this->title,
            'content' => $this->content,
        ]);

        $this->reset(['title', 'content', 'isEdit']);
        $this->posts = Post::all();
    }

    public function delete($id)
    {
        Post::findOrFail($id)->delete();
        $this->posts = Post::all();
    }

    public function archive()
    {
        $this->posts = Post::where('status', 'archived')->get();
    }

    public function render()
    {
//        $res = $this->postsService->getAll($request);
        $res = $this->postsService->getAll([
            'category' => $this->category,
            'keyword' => $this->keyword,
        ]);
        $res['pageName'] = 'Mua bán ' . strtolower($res['category']->name ?? 'tất cả danh mục');
        return view('livewire.post.post-component',$res);
    }
}
