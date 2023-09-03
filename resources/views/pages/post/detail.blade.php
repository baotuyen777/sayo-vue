@extends('layout.index')

@section('content')
    <main class="container">
        <div class="card">
            <h2>Đăng tin mới</h2>
            <div class="card__body ">
                <form method="post" class="form-ajax" enctype="multipart/form-data">
                    <section>
                        <h5>Thông tin bắt buộc</h5>
                        <div>
                            @include('component.form.select',['name'=> 'category_id', 'label' => 'Danh mục','options' => $categories])
                            @include('component.form.input',['name'=> 'name', 'label' => 'Tiêu đề'])
                            @include('component.form.textarea',['name'=> 'content', 'label' => 'Mô tả chi tiết' ,'placeholder' => '
- Thời gian sử dụng
- Bảo hành nếu có
- Sửa chữa, nâng cấp, phụ kiện đi kèm
'])
                            @include('component.form.checkbox',['name'=> 'is_free', 'label' => 'Tôi muốn cho tặng miễn phí'])

                            @include('component.form.input',['name'=> 'price','inputmode'=>"decimal", 'label' => 'Giá bán'])
                            <div>
                                <h5>Hình ảnh và Video sản phẩm</h5>
                                @include('component.form.uploadFiles')
                            </div>
                        </div>
                    </section>

                    <section>
                        <h5>Địa chỉ</h5>
                        {{--                        @include('component.form.select',['name'=> 'address', 'label' => 'Địa chỉ','options' => $address])--}}
                        <a href="{{route('profile')}}">Cài đặt địa chỉ</a>
                        @include('component.form.input',['name'=> 'address', 'label' => 'Địa chỉ chi tiết (Tên đường, Số nhà...)','options' => $address])
                    </section>

                    <section>
                        <h5>Thông tin thêm</h5>
                        <div class="d-flex-wrap grid-2 gap-10">
                            {{--                            @include('component.form.radio',['name'=> 'attr["guarantee"]', 'label' => 'Bảo hành', 'options' => [1=>'Còn bảo hành',2=>'Hết bảo hành']])--}}
                            @include('component.form.select',['name'=> 'attr["state"]', 'label' => 'Tình trạng', 'options' => $postStates])
                            @include('component.form.select',['name'=> 'attr["brand"]', 'label' => 'Hãng/ Thương hiệu', 'options' => $brands])
                            @include('component.form.select',['name'=> 'attr["color"]', 'label' => 'Màu sắc', 'options' => $colors])
                            @include('component.form.select',['name'=> 'attr["storage"]', 'label' => 'Dung lượng', 'options' => $storages])
                            @include('component.form.select',['name'=> 'attr["guarantee"]', 'label' => 'Bảo Hành', 'options' => $postStates])
                            @include('component.form.select',['name'=> 'attr["made_in"]', 'label' => 'Xuất xứ', 'options' => $madeIns])
                        </div>
                    </section>



                    <div class="d-flex justify-content-center">
                        <button class="aw__b1358qut primary r-normal medium w-bold i-left aw__h1gb9yk">
                            {{isset($obj['id']) ? 'Lưu thay đổi' : 'ĐĂNG TIN' }}
                        </button>
                    </div>
                    @csrf
                </form>
            </div>
        </div>

    </main>

@endsection
