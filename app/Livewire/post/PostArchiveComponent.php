<?php

namespace App\Livewire\post;

use App\Models\Post;
use App\Services\Post\PostService;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('abcdd')]
class PostArchiveComponent extends Component
{
    public $posts, $title, $content, $post_id, $post;
    public $where;
    public $isEdit = false;

    use WithPagination;

    public $category;
    public $keyword;

    protected $queryString = [
        'category' => ['except' => ''],
        'keyword' => ['except' => ''],
    ];
    protected $postsService;




    public function mount(Post $post, Request $request, PostService $postService)
    {
        $this->post = $post;
        $this->title = 'abcddd';
        $this->request = $request->all();
        $this->postsService = $postService;
    }


    public function render()
    {
        $routeParams = request()->route()->parameters() ?? [];
        $where = [ ...$routeParams];

        $objs = Post::getAll($where);

        $relationOptions = $this->postsService->getRelationOptions($where);
        $pageName = 'Mua bán ' . strtolower($res['category']->name ?? 'tất cả danh mục');
        return view('livewire.post.post-archive', [...$relationOptions, "objs" => $objs, 'pageName'=> $pageName]);
    }
}
