@extends('layout.index')

@section('content')
    <main>
        <section>
            <div class="container">
                <div class="card">
                    <h2>Khám phá danh mục</h2>
                    <div class="d-flex-wrap grid-6">
                        @foreach(getCategories() as $category)
                            <div>
                                <a href="{{ route('archive', ['catCode' => $category['code']]) }}">
                                    <div class="card--category">
                                        <img alt="{{ $category['name'] }}"
                                             src="{{ $category['avatar']['url'] ?? asset('img/icon/sayo-' . $category['code'] . '.webp') ?? asset('img/icon/sayo-bds.webp') }}">
                                        <div class="card__title">{{ $category['name'] }}</div>
                                    </div>
                                </a>
                            </div>


                        @endforeach

                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="card">
                    <h2>Tin đăng dành cho bạn</h2>
                    <div class="d-flex-wrap grid-6">
                        @foreach($posts as $post)
                            @include('component.post.post_card',['obj'=> $post])
                        @endforeach
                    </div>
                </div>
                <div class="p-10">
                    <a class="view-more" href="{{route('archive',['catCode'=>'tat-ca'])}}">Xem thêm <i id="arrowIcon" class="fa fa-angle-down"></i></a>
                </div>

            </div>
        </section>

        <section>
            <div class="container ">
                <div class="card">
                    <h2>Các từ khóa phổ biến</h2>
                    <ul class="grid-3 gap-10">
                        <li><a href="#">Phòng trọ có gác xép</a></li>
                        <li><a href="#">Phòng trọ dưới 3 triệu</a></li>
                        <li><a href="#">Phòng trọ full đồ</a></li>
                        <li><a href="#">Chung cư mini mỹ đình</a></li>
                        <li><a href="#">Chung cư mini thanh xuân</a></li>
                        <li><a href="#">mặt tiền kinh doanh</a></li>
                    </ul>
                </div>

            </div>
        </section>
    </main>
@endsection
