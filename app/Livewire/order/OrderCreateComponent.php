<?php

namespace App\Livewire\order;

use App\Models\Orders;
use App\Models\Product;
use App\Services\Order\OrderSevice;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OrderCreateComponent extends Component
{
    public $user_infor;
    public $product_id;
    public $product_code;

    protected $rules = [
        'user_infor' => 'required|string|max:255',
        'product_id' => 'required|exists:products,id',
    ];

    protected $messages = [
        'user_infor.required' => 'Vui lòng nhập thông tin khách hàng',
        'product_id.required' => 'Vui lòng chọn sản phẩm',
        'product_id.exists' => 'Sản phẩm không tồn tại',
    ];

    public function mount()
    {
        if (!isLoged()) {
            return redirect()->route('login');
        }
    }

    public function render()
    {
        $products = Product::getAll()->where('author_id', Auth::user()->id);
        
        return view('livewire.order.order-create', [
            'products' => $products
        ]);
    }

    public function store()
    {
        $this->validate();

        $product = Product::find($this->product_id);
        if (!$product) {
            session()->flash('error', 'Sản phẩm không tồn tại');
            return;
        }

        $orderService = app(OrderSevice::class);
        
        $request = new \Illuminate\Http\Request();
        $request->merge([
            'user_infor' => $this->user_infor,
            'product_id' => $this->product_id,
            'product_code' => $product->code
        ]);

        $order = $orderService->store($request);
        
        if ($order) {
            session()->flash('success', 'Tạo đơn hàng thành công!');
            return redirect()->route('order.index');
        }

        session()->flash('error', 'Có lỗi xảy ra khi tạo đơn hàng');
    }

    public function resetForm()
    {
        $this->reset(['user_infor', 'product_id']);
    }
} 