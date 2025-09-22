<?php

namespace App\Livewire\product;

use App\Models\Post;
use App\Models\Orders;
use App\Services\Product\ProductService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProductDetailComponent extends Component
{
    public $code;
    public $showOrderModal = false;
    public $orderMessage = '';
    public $orderSuccess = false;
    private ProductService $service;

    public function __construct()
    {
        $this->service = new ProductService();
    }

    public function mount($code = null)
    {
        $this->code = $code ?? request()->route('code');
    }

    public function createOrder()
    {
        // Check if user is logged in
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $product = Post::getOne($this->code, true, true);
    
        if (!$product) {
            $this->orderMessage = 'Sản phẩm không tồn tại!';
            $this->showOrderModal = true;
            return;
        }

        // Check if user is trying to order their own product
        if ($product->author_id == $user->id) {
            $this->orderMessage = 'Bạn không thể đặt hàng sản phẩm của chính mình!';
            $this->showOrderModal = true;
            return;
        }
        try {
            // Create order
            $order = Orders::create([
                'code' => $user->username . '-' . time(),
                'status' => STATUS_ORDERED,
                'state' => 'init',
                'price' => $product->price,
                'author_id' => $user->id,
                'product_id' => $product->id,
                'seller_id' => $product->author_id,
            ]);

            if ($order) {
                $this->orderSuccess = true;
                $this->orderMessage = 'Đặt hàng thành công! Mã đơn hàng: #' . $order->code;
                $this->showOrderModal = true;
            } else {
                $this->orderMessage = 'Có lỗi xảy ra khi đặt hàng!';
            }
        } catch (\Exception $e) {
            $this->orderMessage = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
    }

    public function closeOrderModal()
    {
        $this->showOrderModal = false;
        $this->orderMessage = '';
        $this->orderSuccess = false;
    }

    public function render()
    {
        $obj = Post::getOne($this->code, true, true);
        if (!$obj) {
            return view('pages.404');
        }

        // Increment view number
//        $this->service->incrementViewNumber($this->code);

        // Wrap the view content in a single root element
        return view('livewire.product.product-detail', ['obj' => $obj]);
    }
}
