<div class="card">
    <h2>{{ $isEdit ? 'Chỉnh sửa tin' : 'Đăng tin mới' }}</h2>
    <div class="card__body ">
        <form wire:submit.prevent="save" enctype="multipart/form-data">
            <section>
                <h5>Thông tin bắt buộc</h5>
                <div>
                    @include('component.form.select',['name'=> 'category_id', 'label' => 'Danh mục','options' => $categories])
                    <div class="d-flex-wrap grid-2 gap-10">
                        @include('component.form.text',['name'=> 'name', 'label' => 'Tiêu đề'])
                        @include('component.form.text',['name'=> 'price','inputmode'=>"decimal", 'label' => 'Giá bán'])
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
                @include('component.form.text',['name'=> 'address', 'label' => 'Địa chỉ chi tiết (Tên đường, Số nhà...)'])
            </section>

            <section>
                <h5>Thông tin thêm <small>(càng chi tiết càng dễ bán hơn)</small></h5>
                <div class="d-flex-wrap grid-2 gap-10 extra-attrs">
                    @include('pages/post/attrs', ['fields' => $fields ?? [], 'attrs' => $attrs ?? []])
                </div>
            </section>
            <section>
                <div>
                    <br>
                    <h5>Xác thực bảo mật</h5>
                    <div class="simple-captcha">
                        <div class="captcha-question">
                            <span>{{ $captchaQuestion }}</span>
                            <button type="button" wire:click="refreshCaptcha" class="btn-refresh-captcha">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                        <div class="captcha-input">
                            <input type="text" wire:model="captchaAnswer" placeholder="Nhập kết quả" class="form-control">
                            @error('captchaAnswer')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </section>

            <div class="d-flex justify-content-center gap-10">
                <a class="btn btn-back" href="{{route('shop',['code'=>Auth()->user()->username])}}">
                    Về danh sách</a>
                <button type="button" wire:click="testMethod" class="btn btn-secondary">
                    Test Livewire
                </button>
                <button type="submit" class="btn--primary btn-submit">
                    {{isset($obj['id']) ? 'Lưu thay đổi' : 'ĐĂNG TIN' }}
                </button>
                @if(isset($obj['id']))
                    <a class="btn"
                       href="{{route('postView',['catCode'=>$obj['category']['code'],'code'=>$obj['code']])}}"
                       target="_blank">Xem trước</a>
                @endif
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('livewire:init', () => {
    Livewire.on('validation-failed', (errors) => {
        console.log('Validation failed:', errors);
        // Refresh captcha when validation fails
        if (errors.captchaAnswer) {
            // The captcha will be automatically refreshed by the component
        }
    });
    
    // Debug: Log when form is submitted
    document.querySelector('form').addEventListener('submit', function(e) {
        console.log('Form submitted!');
    });
    
    // Debug: Log when save method is called
    Livewire.on('save-called', () => {
        console.log('Save method called!');
    });
    
    // Debug: Log when test method is called
    Livewire.on('test-called', (event) => {
        console.log('Test method called!', event.message);
        alert('Livewire is working! Message: ' + event.message);
    });
});
</script>
