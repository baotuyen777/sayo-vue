@extends('layout.index')

@section('content')
    <main class="container">
        <div class="card">
            <h2>Đăng tin mới</h2>
            <div class="card__body ">
                <form method="post">
                    <section class="">
                        <h3 class="">Thông tin bắt buộc</h3>
                        <div class="">
                            @include('component.form.select',['name'=> 'category_id', 'label' => 'Danh mục','options' => $categories])
                            @include('component.form.input',['name'=> 'name', 'label' => 'Tiêu đề'])
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
                        <a href="{{route('profile')}}">Cài đặt địa chỉ</a>
                        @include('component.form.input',['name'=> 'address', 'label' => 'Địa chỉ chi tiết (Tên đường, Số nhà...)','options' => $address])
                    </div>

                    <section>
                        <h3 class="">Thông tin thêm</h3>
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

                    <section>
                        <div class="input-field">
                            <label class="active">Hình ảnh sản phẩm</label>
                            <div class="input-images-2" style="padding-top: .5rem;padding-bottom: .5rem;"></div>
                        </div>
                    </section>

                    <div class="d-flex justify-content-center">
                        <button class="aw__b1358qut primary r-normal medium w-bold i-left aw__h1gb9yk">ĐĂNG TIN
                        </button>
                    </div>
                    @csrf
                </form>
            </div>
        </div>

    </main>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <script src="https://www.jqueryscript.net/demo/drag-drop-image-uploader/dist/image-uploader.min.js"></script>
    <script>
        let preloaded = [
            {id: 1, src: 'https://picsum.photos/500/500?random=1'},
            {id: 2, src: 'https://picsum.photos/500/500?random=2'},
            {id: 3, src: 'https://picsum.photos/500/500?random=3'},
            {id: 4, src: 'https://picsum.photos/500/500?random=4'},
            {id: 5, src: 'https://picsum.photos/500/500?random=5'},
            {id: 6, src: 'https://picsum.photos/500/500?random=6'},
        ];

        jQuery('.input-images-2').imageUploader({
            preloaded: preloaded,
            imagesInputName: 'photos',
            preloadedInputName: 'old'
        });

        jQuery('form').on('submit', function (event) {

            // Stop propagation
            event.preventDefault();
            event.stopPropagation();

            // Get some vars
            let $form = jQuery(this),
                $modal = jQuery('.modal');

            // Set name and description
            $modal.find('#display-name span').text($form.find('input[id^="name"]').val());
            $modal.find('#display-description span').text($form.find('input[id^="description"]').val());

            // Get the input file
            let $inputImages = $form.find('input[name^="images"]');
            if (!$inputImages.length) {
                $inputImages = $form.find('input[name^="photos"]')
            }

            // Get the new files names
            let $fileNames = jQuery('<ul>');
            for (let file of $inputImages.prop('files')) {
                jQuery('<li>', {text: file.name}).appendTo($fileNames);
            }

            // Set the new files names
            $modal.find('#display-new-images').html($fileNames.html());

            // Get the preloaded inputs
            let $inputPreloaded = $form.find('input[name^="old"]');
            if ($inputPreloaded.length) {

                // Get the ids
                let $preloadedIds = jQuery('<ul>');
                for (let iP of $inputPreloaded) {
                    jQuery('<li>', {text: '#' + iP.value}).appendTo($preloadedIds);
                }

                // Show the preloadede info and set the list of ids
                $modal.find('#display-preloaded-images').show().html($preloadedIds.html());

            } else {

                // Hide the preloaded info
                $modal.find('#display-preloaded-images').hide();

            }

            // Show the modal
            $modal.css('visibility', 'visible');
        });

        // Input and label handler
        jQuery('input').on('focus', function () {
            jQuery(this).parent().find('label').addClass('active')
        }).on('blur', function () {
            if (jQuery(this).val() == '') {
                jQuery(this).parent().find('label').removeClass('active');
            }
        });

    </script>
@endsection
