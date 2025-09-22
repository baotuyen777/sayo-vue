<?php

namespace App\Livewire\order;

use App\Models\Category;
use App\Models\Orders;
use App\Services\Order\OrderSevice;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class OrderListComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $dateFrom = null;
    public $dateTo = null;
    public $currentPage = 1;
    public $pageSize = 24;
    public $isSeller = false;
    public $isAdmin = false;
    public $seller_id = null;

    public function mount()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Check if user is admin or seller
        $this->isAdmin = isAdmin();
        $this->isSeller = $user->role !== ROLE_ADMIN;
        
        if ($this->isSeller) {
            $this->seller_id = $user->id;
        }
    }

    public function render()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $orderService = app(OrderSevice::class);
        
        // Create request object with filters
        $request = new \Illuminate\Http\Request();
        
        if ($this->dateFrom) {
            $request->merge(['date_from' => $this->dateFrom]);
        }
        if ($this->dateTo) {
            $request->merge(['date_to' => $this->dateTo]);
        }
        
        // Apply user role filters
        if ($this->isSeller) {
            $request->merge(['seller_id' => $user->id]);
        } elseif (!$this->isAdmin) {
            $request->merge(['author_id' => $user->id]);
        }

        $order = $orderService->list($request);

        $totalPrice = $order['orders']->getCollection()->sum('price');
        $categories = Category::with('avatar')->get();

        return view('livewire.order.order-list', [
            'orders' => $order['orders'],
            'totalPrice' => $totalPrice,
            'categories' => $categories,
        ]);
    }

    public function updateFilters()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->dateFrom = null;
        $this->dateTo = null;
        $this->resetPage();
    }

    public function updateStatus($orderId, $status)
    {
        $user = Auth::user();
        if (!$user) {
            return;
        }

        $order = Orders::find($orderId);
        if (!$order) {
            return;
        }

        // Check if user has permission to update this order
        if ($user->role !== ROLE_ADMIN && $order->seller_id !== $user->id) {
            return;
        }

        $order->update(['status' => $status]);

        // Show success message
        session()->flash('message', 'Cập nhật trạng thái đơn hàng thành công!');
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
        } else {
            session()->flash('error', 'Có lỗi xảy ra khi xóa đơn hàng');
        }
    }
}
