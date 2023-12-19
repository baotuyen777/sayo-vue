@extends('layout.seller')

@section('content')
    <div class="card">
        <div class="card__body ">
            <form method="post" class="form-ajax" enctype="multipart/form-data"
                  action="{{route('user.update',['user'=>$obj['username']])}}" data-id={{$obj['username']}}>

                <section>
                    <h5>Hồ sơ cá nhân</h5>
                    <div>
                        @include('component.form.text',['name'=> 'name', 'label' => 'Tiêu đề'])
                        @include('component.form.textarea',['name'=> 'bio', 'label' => 'Giới thiệu', 'placeholder'=> 'Viết vài dòng giới thiệu về bạn'])

                    </div>
                </section>

                <section>
                    <h5>Địa chỉ <a href="{{route('profile')}}">Cài đặt địa chỉ</a></h5>
                    <div class="grid-3 gap-10">
                        @include('component.form.selectAsync',['name'=> 'province_id', 'label' => 'Tỉnh/thành phố', 'options' => $provinces,
'asyncUrl' =>route('getDistricts'), 'asyncField' =>'district_id', 'valueLabel'=>$obj['province_name'] ?? ''])
                        @include('component.form.selectAsync',['name'=> 'district_id', 'label' => 'Quận/Huyện', 'options' => $districts,
'asyncUrl' =>route('getWards'), 'asyncField' =>'ward_id','valueLabel'=>$obj['district_name'] ?? ''])
                        @include('component.form.selectAsync',['name'=> 'ward_id', 'label' => 'Xã/phường', 'options' => $wards, 'valueLabel'=>$obj['ward_name']?? ''])
                    </div>


                    @include('component.form.text',['name'=> 'address', 'label' => 'Địa chỉ chi tiết (Tên đường, Số nhà...)'])
                </section>
                <section>
                    <h5>Thông tin bảo mật</h5>
                    @include('component.form.text',['name'=> 'email', 'label' => 'Email'])
                    @include('component.form.text',['name'=> 'cccd', 'label' => 'Căn cước công dân','maxlength' =>12])
                    @include('component.form.text',['name'=> 'birthday', 'label' => 'Ngày sinh','type'=>'date'])
                    @include('component.form.select',['name'=> 'gender', 'label' => 'Giới tính','options'=>$genders])
                </section>

                <div class="d-flex justify-content-center">
                    <button class="btn btn--primary">Lưu thay đổi</button>
                </div>
                @method('PUT')
                @csrf
            </form>
        </div>
    </div>

@endsection
