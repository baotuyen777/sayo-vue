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
                            <div class="d-flex-wrap grid-2 gap-10">
                                @include('component.form.input',['name'=> 'name', 'label' => 'Tiêu đề'])
                                @include('component.form.input',['name'=> 'price','inputmode'=>"decimal", 'label' => 'Giá bán'])
                            </div>
                            @include('component.form.textarea',['name'=> 'content', 'label' => 'Mô tả chi tiết' ,'placeholder' => '
- Thời gian sử dụng
- Bảo hành nếu có
- Sửa chữa, nâng cấp, phụ kiện đi kèm
'])
                            <div>
                                <h5>Hình ảnh và Video sản phẩm</h5>
                                @include('component.form.uploadFiles')
                            </div>
                        </div>
                    </section>

                    <section>
                        <h5>Địa chỉ</h5>
                        <div class="grid-3 gap-10">
                            @include('component.form.selectAsync',['name'=> 'province_id', 'label' => 'Tỉnh/thành phố', 'options' => $provinces,
'asyncUrl' =>route('getDistricts'), 'asyncField' =>'district_id', 'valueLabel'=>$obj['province_name'] ?? ''])
                            @include('component.form.selectAsync',['name'=> 'district_id', 'label' => 'Quận/Huyện', 'options' => $districts,
'asyncUrl' =>route('getWards'), 'asyncField' =>'ward_id','valueLabel'=>$obj['district_name'] ?? ''])
                            @include('component.form.selectAsync',['name'=> 'ward_id', 'label' => 'Xã/phường', 'options' => $wards, 'valueLabel'=>$obj['ward_name']?? ''])
                        </div>

                        <a href="{{route('profile')}}">Cài đặt địa chỉ</a>
                        @include('component.form.input',['name'=> 'address', 'label' => 'Địa chỉ chi tiết (Tên đường, Số nhà...)'])
                    </section>

                    <section>
                        <h5>Thông tin thêm <small>(càng chi tiết càng dễ bán hơn)</small></h5>
                        <div class="d-flex-wrap grid-2 gap-10">
                            {{--                            @include('component.form.radio',['name'=> 'attr["guarantee"]', 'label' => 'Bảo hành', 'options' => [1=>'Còn bảo hành',2=>'Hết bảo hành']])--}}
                            @include('component.form.select',['name' => 'state', 'label' => 'Tình trạng','isAttr' => 1])
                            @include('component.form.select',['name' => 'color', 'label' => 'Màu sắc','isAttr' => 1])
                            @include('component.form.select',['name' => 'guarantee', 'label' => 'Bảo hành','isAttr'=> 1])
                            @include('component.form.select',['name' => 'made_in', 'label' => 'Xuất xứ','isAttr'=> 1])
                            {{--                            @include('component.form.select',['name'=> 'attr["brand"]', 'label' => 'Hãng/ Thương hiệu', 'options' => $brands,'attr'=>'brand'])--}}
                            {{--                            @include('component.form.select',['name'=> 'attr["color"]', 'label' => 'Màu sắc', 'options' => $colors,'attr'=>'color'])--}}
                            {{--                            @include('component.form.select',['name'=> 'attr["storage"]', 'label' => 'Dung lượng', 'options' => $storages,'attr'=>'storage'])--}}
                            {{--                            @include('component.form.select',['name'=> 'attr["guarantee"]', 'label' => 'Bảo Hành', 'options' => $postStates,'attr'=>'guarantee'])--}}
                            {{--                            @include('component.form.select',['name'=> 'attr["made_in"]', 'label' => 'Xuất xứ', 'options' => $madeIns,'attr'=>'made_in'])--}}
                            {{--                            @include('component.form.input',['name'=> 'attr["acreage"]', 'label' => 'Diện tích', 'attr'=>'acreage'])--}}
                        </div>
                    </section>
                    <section>
                        <div>
                            <h5>ReCaptcha: </h5>
                            <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}"></div>
                            @error('g-recaptcha-response')
                            <p>{{ $message }}</p>
                            @enderror
                            <p class="validate validate-g-recaptcha-response"></p>
                        </div>
                    </section>


                    <div class="d-flex justify-content-center gap-10">
                        <a class="btn btn-back" href="{{route('user.show',['user'=>Auth()->user()->username])}}">
                            Về danh sách</a>
                        <button class="btn--primary btn-submit">
                            {{isset($obj['id']) ? 'Lưu thay đổi' : 'ĐĂNG TIN' }}
                        </button>
                        @if(isset($obj['id']))
                            <a class="btn"
                               href="{{route('postView',['catSlug'=>$obj['category']['code'],'slug'=>$obj['code']])}}"
                               target="_blank">Xem trước</a>
                        @endif
                    </div>
                    @csrf
                </form>
            </div>
        </div>

    </main>

@endsection
@push('js')
<script src='https://www.google.com/recaptcha/api.js'></script>
@endpush
