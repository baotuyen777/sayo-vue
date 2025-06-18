<?php

namespace App\Livewire\product;

use App\Models\Post;
use App\Services\Product\ProductService;
use Livewire\Component;

class ProductDetailComponent extends Component
{
    public $code;
    private ProductService $service;

    public function __construct()
    {
        $this->service = new ProductService();
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
//        $this->service->incrementViewNumber($this->code);

        // Wrap the view content in a single root element
        return view('livewire.product.product-detail', ['obj' => $obj]);
    }
}
