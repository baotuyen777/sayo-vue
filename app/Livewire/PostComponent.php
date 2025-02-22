<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class PostComponent extends Component
{
    public $posts, $title, $content, $post_id;
    public $isEdit = false;

    public function mount()
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

    public function render()
    {
        return view('livewire.post-component');
    }
}
