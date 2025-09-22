<div class="container">
    <section class="card">
        <h2>Đơn hàng: #{{ $order->code }}</h2>
        <div class="card__body">
            <div class="d-flex-wrap grid-3 gap-10">
                <div class="col-md-6">
                    <h5>Thông tin đơn hàng</h5>
                    <p><strong>Mã đơn hàng:</strong> #{{ $order->code }}</p>
                    <p><strong>Sản phẩm:</strong> {{ $order->product->name ?? 'N/A' }}</p>
                    <p><strong>Giá:</strong> {{ moneyFormat($order->price) }}</p>
                    <p><strong>Thời gian tạo:</strong> {{ showHumanTime($order->created_at) }}</p>
                    <p><strong>Trạng thái:</strong>
                        <span class="badge badge-{{ $order->status == 1 ? 'warning' : ($order->status == 2 ? 'info' : 'success') }}">
                            {{ $statuses[$order->status] ?? 'N/A' }}
                        </span>
                    </p>
                </div>

                <div class="col-md-6">
                    <h5>Thông tin khách hàng</h5>
                    <p><strong>Khách hàng:</strong> {{ $order->author->name ?? 'N/A' }}</p>
                    <p><strong>Email:</strong> {{ $order->author->email ?? 'N/A' }}</p>
                    <p><strong>Số điện thoại:</strong> {{ $order->author->phone ?? 'N/A' }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $order->author->address ?? 'N/A' }}</p>
                </div>
                @if($order->seller)
                    <div class="col-md-6">
                        <h5>Thông tin người bán</h5>
                        <p><strong>Người bán:</strong> {{ $order->seller->name ?? 'N/A' }}</p>
                        <p><strong>Email:</strong> {{ $order->seller->email ?? 'N/A' }}</p>
                        <p><strong>Số điện thoại :</strong> {{ $order->seller->phone ?? 'N/A' }}</p>
                        <p><strong>Địa chỉ:</strong> {{ $order->seller->address ?? 'N/A' }}</p>
                    </div>
                @endif
            </div>


        </div>
    </section>

    <div class="mt-3">
        <a class="btn btn--primary" href="{{ route('order.index') }}">Danh sách đơn đã đặt</a>
        @if(isAdmin() || (Auth::user() && $order->seller_id == Auth::user()->id))
            <button class="btn btn--danger" wire:click="destroy({{ $order->id }})"
                    onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')">
                Xóa đơn hàng
            </button>
        @endif
    </div>
</div>
