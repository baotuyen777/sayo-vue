@include('layout.header')

<main>
    <section class="">
        <div class="container">
            <div class="card">
                <h2>Khám phá danh mục</h2>
                <div class="d-flex-wrap grid-2">
                    @foreach($categories as $category)
                        <div>
                            <a href="#">
                                <div class="card--category">
                                    <img alt="{{$category['name']}}"
                                         src="{{$category['avatar']['url'] ?? asset('img/icon/sayo-bds.webp')}}"
                                    >
                                    <div class="card__title">{{$category['name']}}</div>
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
                        @include('component.post',['obj'=> $post])
                    @endforeach
                </div>
            </div>
            <div class="p-10">
                <a class="view-more">Xem thêm <i id="arrowIcon" class="fa fa-angle-down"></i></a>
            </div>

        </div>
    </section>

    <section>
        <div class="container ">
            <div class="card">
                <h2>Các từ khóa phổ biến</h2>
                <ul>
                    <li><a href="#">Samsung Note 10</a></li>
                </ul>
            </div>

        </div>
    </section>
</main>
@include('layout.footer')
