@extends('layout.index')

@section('content')
    <main class="container">
        <div class="card">
            <h2>Tạo đơn hàng</h2>
            <div class="card__body ">
                <form method="post" class="form-ajax" enctype="multipart/form-data" action="{{ route('sellerStore') }}">
                    <section>
                        <h5>Thông tin bắt buộc</h5>
                        <div>
                            <div class="gap-10">
                                <h5>User Name/Số điện thoại/Email</h5>
                                @include('component.form.text',['name'=> 'user_infor', 'label' => 'User Name/Số điện thoại/Email'])
                                <h5>Chọn sản phẩm</h5>
                                @include('component.form.select',['name'=> 'product_id', 'label' => 'Chọn sản phẩm','options' => $product])
                            </div>
                        </div>
                    </section>
                    <div class="d-flex justify-content-center gap-10">
                        <a class="btn btn-back" href="">
                            Về danh sách</a>
                        <button class="btn--primary btn-submit">
                                                        Lưu thay đổi
                        </button>
                    </div>
                    @csrf
                </form>
            </div>
        </div>
    </main>
@endsection
