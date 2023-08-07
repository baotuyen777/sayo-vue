@include('layout.header')

<main>
    <section class="">
        <div class="container white-box">
            <h2>Khám phá danh mục</h2>
            <div class="">
                <div class="d-flex-wrap grid-2">
                    <?php for ($i = 0;
                               $i < 12;
                               $i++): ?>
                    <div><a>
                            <div class="card--category">
                                <img alt="Bất động sản"
                                     src="https://lighthouse.chotot.com/_next/image?url=https%3A%2F%2Fstatic.chotot.com%2Fstorage%2Fchapy-pro%2Fnewcats%2Fv8%2F1000.png&amp;w=256&amp;q=95"
                                >
                                <div class="card__title">Bất động sản</div>
                            </div>

                        </a>
                    </div>
                    <?php endfor; ?>

                </div>
            </div>
        </div>

    </section>
    <section>
        <div class="container white-box">
            <h2>Tin đăng dành cho bạn</h2>

            <div class="d-flex-wrap grid-3">
                <?php for ($i = 0;
                           $i < 10;
                           $i++): ?>
                @include('component.product')
                <?php endfor; ?>
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
