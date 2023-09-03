@extends('layout.index')

@section('content')
    <main class="container">
        <div class="card">
            <h2>Đăng tin mới</h2>
            <div class="card__body ">
                <form method="post" class="form-ajax" enctype="multipart/form-data">
                    <section class="">
                        <h3 class="">Thông tin bắt buộc</h3>

                            @include('component.form.select',['name'=> 'category_id', 'label' => 'Danh mục','options' => $categories])
                            @include('component.form.input',['name'=> 'name', 'label' => 'Tiêu đề'])
                            @include('component.form.textarea',['name'=> 'content', 'label' => 'Mô tả chi tiết' ,'placeholder' => '
- Thời gian sử dụng
- Bảo hành nếu có
- Sửa chữa, nâng cấp, phụ kiện đi kèm
'])
                            @include('component.form.checkbox',['name'=> 'is_free', 'label' => 'Tôi muốn cho tặng miễn phí'])

                            @include('component.form.input',['name'=> 'price','inputmode'=>"decimal", 'label' => 'Giá bán'])

                                <h5>Hình ảnh và Video sản phẩm</h5>


                    </section>

                    <div class="">
                        <h3>Địa chỉ</h3>
                        @include('component.form.select',['name'=> 'category_id', 'label' => 'Địa chỉ','options' => $address])
                        <a href="{{route('profile')}}">Cài đặt địa chỉ</a>
                        @include('component.form.input',['name'=> 'address', 'label' => 'Địa chỉ chi tiết (Tên đường, Số nhà...)','options' => $address])
                    </div>

                    <section>
                        <h3 class="">Thông tin thêm</h3>
                        <div class="d-flex-wrap grid-2 gap-10">
                            @include('component.form.radio',['name'=> 'attr["guarantee"]', 'label' => 'Bảo hành', 'options' => [1=>'Còn bảo hành',2=>'Hết bảo hành']])
                            @include('component.form.select',['name'=> 'attr["state"]', 'label' => 'Tình trạng', 'options' => $postStates])
                            @include('component.form.select',['name'=> 'attr["brand"]', 'label' => 'Hãng/ Thương hiệu', 'options' => $brands])
                            @include('component.form.select',['name'=> 'attr["color"]', 'label' => 'Màu sắc', 'options' => $colors])
                            @include('component.form.select',['name'=> 'attr["storage"]', 'label' => 'Dung lượng', 'options' => $storages])
                            @include('component.form.select',['name'=> 'attr["guarantee"]', 'label' => 'Bảo Hành', 'options' => $postStates])
                            @include('component.form.select',['name'=> 'attr["made_in"]', 'label' => 'Xuất xứ', 'options' => $madeIns])
                        </div>
                    </section>

                    <section>
                        <div class="input-field">
                            <label class="active">Hình ảnh sản phẩm</label>
                            <div class="input-images-2"></div>
                        </div>
                    </section>

                    <section>
                        <input type="file" name="files[]" id="files" accept="image/*" multiple/>
                        <button class="btn btn-primary btn_addfile" type="button">
                            <i class="fa fa-picture-o" aria-hidden="true"></i> Thêm ảnh
                        </button>
                        <br> <br>
                        <div class="post_thumb"></div>
                        <div id="preview"></div>
                    </section>

                    <div class="d-flex justify-content-center">
                        <button class=" primary r-normal medium w-bold i-left ">ĐĂNG TIN
                        </button>
                    </div>
                    @csrf
                </form>
            </div>
        </div>

    </main>

    <script>
        var state = {};
        $(document).ready(function () {
            $('#files').change(function () {

                var form_data = new FormData();

                // Read selected files
                var totalfiles = document.getElementById('files').files.length;
                for (var index = 0; index < totalfiles; index++) {
                    form_data.append("files[]", document.getElementById('files').files[index]);
                }

                $.ajax({
                    url: '/api/medias',
                    type: 'post',
                    data: form_data,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        state.media_ids = response.ids
                        for (let index = 0; index < response.result.length; index++) {
                            var src = response.result[index].url_full;

                            // Add img element in <div id='preview'>
                            $('#preview').append(`<img src="${src}">`);
                        }

                    }
                });

            });

        });

        jQuery('.btn_addfile').click(function (e) {
            e.preventDefault();
            $('#files').click();
        });




    </script>
@endsection
