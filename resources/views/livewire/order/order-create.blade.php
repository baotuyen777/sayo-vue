<main class="container">
    <div class="card">
        <h2>Tạo đơn hàng</h2>
        <div class="card__body">
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form wire:submit.prevent="store" enctype="multipart/form-data">
                <section>
                    <h5>Thông tin bắt buộc</h5>
                    <div>
                        <div class="gap-10">
                            <h5>User Name/Số điện thoại/Email</h5>
                            <div class="form-group">
                                <label for="user_infor">User Name/Số điện thoại/Email</label>
                                <input type="text" 
                                       id="user_infor" 
                                       wire:model="user_infor" 
                                       class="form-control @error('user_infor') is-invalid @enderror"
                                       placeholder="Nhập thông tin khách hàng">
                                @error('user_infor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <h5>Chọn sản phẩm</h5>
                            <div class="form-group">
                                <label for="product_id">Chọn sản phẩm</label>
                                <select id="product_id" 
                                        wire:model="product_id" 
                                        class="form-control @error('product_id') is-invalid @enderror">
                                    <option value="">Chọn sản phẩm</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }} - {{ moneyFormat($product->price) }}</option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </section>
                
                <div class="d-flex justify-content-center gap-10">
                    <a class="btn btn-back" href="{{ route('order.index') }}">
                        Về danh sách
                    </a>
                    <button type="button" wire:click="resetForm" class="btn btn--gray">
                        Làm mới
                    </button>
                    <button type="submit" class="btn--primary btn-submit">
                        Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>
</main> 