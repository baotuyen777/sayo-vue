@include('layout.header')

<main>
    <section class="">
        <div class="container white-box">
            <h2>Khám phá danh mục</h2>
            <div class="">
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
        <div class="container white-box">
            <h2>Tin đăng dành cho bạn</h2>

            <div class="d-flex-wrap grid-5">
                @foreach($posts as $post)
                    @include('component.product',['obj'=> $post])
                @endforeach
            </div>


            <div>
                <button type="button">Xem thêm <i id="arrowIcon" class="fa fa-angle-down"
                                                  aria-hidden="true"></i></button>
            </div>

        </div>
    </section>

    <section>

        <div class="container white-box">
            <h3
                class="Keywords__Title-sc-10bnl27-0 BKMXI">Các từ khóa phổ biến</h3>
            <ul class="Keywords__Ul-sc-10bnl27-1 cCTTIh">
                <li><a href="https://www.chotot.com/mua-ban-dien-thoai-samsung-galaxy-note-10-sdmd2ml820"
                    ><span>Samsung Note 10</span></a></li>
            </ul>
        </div>
    </section>
</main>
@include('layout.footer')
