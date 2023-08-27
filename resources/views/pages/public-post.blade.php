@extends('layout.index')

@section('content')
    <main class="container">
        <div class="card">
            <h2>Đăng tin mới</h2>
            <div class="card__body ">
                <form>
                    <section class="">
                        <h3 class="">Thông tin bắt buộc</h3>
                        <div class="">
                            @include('component.form.select',['name'=> 'category_id', 'label' => 'Danh mục','options' => $categories])
                            @include('component.form.input',['name'=> 'content', 'label' => 'Tiêu đề'])
                            @include('component.form.textarea',['name'=> 'content', 'label' => 'Mô tả chi tiết'])
                            @include('component.form.checkbox',['name'=> 'is_free', 'label' => 'Tôi muốn cho tặng miễn phí'])

                            @include('component.form.input',['name'=> 'price','inputmode'=>"decimal", 'label' => 'Giá bán'])
                            <div class="">
                                <h5>Hình ảnh và Video sản phẩm</h5>
                            </div>
                        </div>
                    </section>

                    <div class="">
                        <h3>Địa chỉ</h3>
                        @include('component.form.select',['name'=> 'category_id', 'label' => 'Địa chỉ','options' => $address])
                        @include('component.form.input',['name'=> 'address', 'label' => 'Địa chỉ chi tiết (Tên đường, Số nhà...)','options' => $address])
                    </div>

                    <section>
                        <h3 class="">Thông tin thêm</h3>
                        <div class="d-flex-wrap grid-2">
                            @include('component.form.radio',['name'=> 'guarantee', 'label' => 'Bảo hành', 'options' =>[1=>'Còn bảo hành',2=>'Hết bảo hành']])
                            @include('component.form.select',['name'=> 'category_id', 'label' => 'Tình trạng','options' => $postStates])
                        </div>
                    </section>

                    <div class="d-flex justify-content-center">
                        <button class="aw__b1358qut primary r-normal medium w-bold i-left aw__h1gb9yk"
                                type="button">ĐĂNG TIN
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </main>
@endsection
