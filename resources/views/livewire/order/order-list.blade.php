{{--@extends('layout.index')--}}
<main>
    {{--@section('content')--}}
    <div class="container">
        <section class="card">
            <div class="card__header d-flex justify-content-between align-items-center">
                <h2>{{ $isSeller ? 'Quản lý đơn hàng' : 'Đơn hàng của tôi' }}</h2>
                @if($isSeller)
                    <a href="{{ route('order.create') }}" class="btn btn--primary">
                        <i class="fas fa-plus"></i> Tạo đơn hàng
                    </a>
                @endif
            </div>
            <div class="card__body">
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Filters -->
                <div class="filters mb-4">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Từ ngày:</label>
                            <input type="date" wire:model.live="dateFrom" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label>Đến ngày:</label>
                            <input type="date" wire:model.live="dateTo" class="form-control">
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <button wire:click="clearFilters" class="btn btn--gray me-2">Xóa bộ lọc</button>
                        </div>
                    </div>
                </div>

                <!-- Revenue Display -->
                @if($isSeller)
                    <div class="revenue-info mb-3">
                        <p class="text-success"><strong>Doanh thu: {{ moneyFormat($totalPrice) }}</strong></p>
                    </div>
                @endif

                <!-- Orders Table -->
                @if($orders->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>STT</th>
                                <th width="160">Mã đơn hàng</th>
                                <th>Khách hàng</th>
                                <th>Sản phẩm</th>
                                <th width="150" >Giá</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $index => $order)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <a href="{{ route('order.show', ['code' => $order->code]) }}">#{{ $order->code }}</a>
                                        <div>{{ $order->created_at->format('d/m/Y H:i') }}</div>
                                    </td>
                                    <td>
                                        <div>{{ $order->author->name ?? 'N/A' }}</div>
                                        <div class="text-muted">{{ $order->author->email ?? 'N/A' }}</div>
                                        <div class="text-muted">{{ $order->author->phone ?? 'N/A' }}</div>
                                    </td>
                                    <td>{{ $order->product->name ?? 'N/A' }}</td>
                                    <td>{{ moneyFormat($order->price) }}</td>
                                    <td>
                                <span
                                    class="badge badge-{{ $order->status == 1 ? 'warning' : ($order->status == 2 ? 'info' : 'success') }}">
                                    {{ \App\Models\Orders::$status[$order->status] ?? 'N/A' }}
                                </span>
                                    </td>

                                    <td>
                                        <div class="btn-group">
                                            @if($isSeller || isAdmin())
                                                @if($order->status == STATUS_ORDERED)
                                                    <button class="btn btn-sm btn--primary"
                                                            wire:click="updateStatus({{ $order->id }}, {{ STATUS_PROCESSING }})">
                                                        Đang xử lý
                                                    </button>
                                                @endif
                                                @if($order->status == STATUS_PROCESSING)
                                                    <button class="btn btn-sm btn--success"
                                                            wire:click="updateStatus({{ $order->id }}, {{ STATUS_COMPLETED }})">
                                                        Hoàn thành
                                                    </button>
                                                @endif
                                                @if($order->status == STATUS_COMPLETED)
                                                    <button class="btn btn-sm btn--gray"
                                                            wire:click="updateStatus({{ $order->id }}, {{ STATUS_ORDERED }})">
                                                        Reset
                                                    </button>
                                                @endif
                                            @endif

                                            @if($isSeller || isAdmin())
                                                <button class="btn btn-sm btn--danger"
                                                        wire:click="destroy({{ $order->id }})"
                                                        onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')">
                                                    Xóa
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="pagination-wrapper">
                        {{ $orders->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <p class="text-muted">Không có đơn hàng nào.</p>
                        <a href="{{ route('home') }}" class="btn btn--primary">Mua sắm ngay</a>
                    </div>
                @endif
            </div>
        </section>
    </div>
    {{--@endsection--}}
</main>
