<?php

namespace App\Livewire\order;

use App\Models\Category;
use App\Models\Orders;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class MyOrderComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $dateFrom = null;
    public $dateTo = null;
    public $currentPage = 1;
    public $pageSize = 24;
    public $isSeller = false;

    public function mount()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Check if user is admin or seller
        $this->isSeller = $user->role !== ROLE_ADMIN;
    }

    public function render()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $orders = Orders::with('author', 'product', 'seller');

        // Apply filters
        if ($this->dateFrom) {
            $orders->where('created_at', '>=', $this->dateFrom);
        }
        if ($this->dateTo) {
            $orders->where('created_at', '<=', $this->dateTo);
        }

        // Filter by user role
        if ($this->isSeller) {
            $orders->where('seller_id', $user->id);
        } else {
            // For regular users, show their own orders
            $orders->where('author_id', $user->id);
        }

        $orders = $orders->orderBy('created_at', 'desc')
                        ->paginate($this->pageSize, ['*'], 'page', $this->currentPage);

        $totalPrice = $orders->getCollection()->sum('price');
        $categories = Category::with('avatar')->get();

        return view('livewire.order.order-list', [
            'orders' => $orders,
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
}
