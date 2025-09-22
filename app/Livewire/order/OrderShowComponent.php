<?php

namespace App\Livewire\order;

use App\Models\Orders;
use App\Services\Order\OrderSevice;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OrderShowComponent extends Component
{
    public $orderCode;
    public $order;

    public function mount($code)
    {
        $this->orderCode = $code;
        $this->order = Orders::query()->where('code', $code)->first();
        
        if (!$this->order) {
            abort(404);
        }
    }

    public function render()
    {
        return view('livewire.order.order-show', [
            'order' => $this->order,
            'statuses' => Orders::$status
        ]);
    }

    public function destroy($orderId)
    {
        $user = Auth::user();
        if (!$user) {
            return;
        }

        $order = Orders::find($orderId);
        if (!$order) {
            return;
        }

        // Check if user has permission to delete this order
        if ($user->role !== ROLE_ADMIN && $order->seller_id !== $user->id) {
            return;
        }

        $orderService = app(OrderSevice::class);
        $result = $orderService->destroy($orderId);

        if ($result) {
            session()->flash('message', 'Xóa đơn hàng thành công!');
            return redirect()->route('order.index');
        } else {
            session()->flash('error', 'Có lỗi xảy ra khi xóa đơn hàng');
        }
    }
} 