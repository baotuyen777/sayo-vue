<?php require 'header.php' ?>
<main>
    <section class="">
        <div class="container white-box">
            <h2>Khám phá danh mục</h2>
            <div class="">
                <div class="d-flex-wrap grid-2">
                    <?php for ($i = 0; $i < 12; $i++): ?>
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
                <?php for($i=0; $i<10; $i++): ?>
                <div class="card product">
                    <div class="">
                        <a target="_blank"
                           href="https://www.nhatot.com/mua-ban-nha-dat-quan-hai-ba-trung-ha-noi/108741702.htm?_ga=2.1691080137174.886120900.1687695810">
                            <div class="ImageLabel_gridViewOverlay__DW_vi">
                                <img id="ad-label-image" alt=""></div>
                            <img
                                alt="1.4tỷ nhà 4T lô góc DT20m-Hộ khẩu HBT-O có căn thứ2-Sổ đỏ riêng biệt"
                                src="https://cdn.chotot.com/ygNUVR-m9Fsdf18fgwfKbG4KxK5-VVPg1ysGA44sPu4/preset:listing/plain/cf7fa21d4e02925500943432d43178b6-2837014968452043029.jpg"
                                loading="lazy">
                        </a>

                    </div>
                    <div class="product__caption">
                        <a target="_blank"
                           href="https://www.nhatot.com/mua-ban-nha-dat-quan-hai-ba-trung-ha-noi/108741702.htm?_ga=2.1691080137174.886120900.1687695810">1.4tỷ
                            nhà 4T lô góc DT20m-Hộ khẩu HBT-O có căn thứ...</a>
                        <div class="product__feedback">
                            <div>
                                <button type="button" aria-haspopup="true" aria-expanded="false">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="8" cy="2" r="2" transform="rotate(90 8 2)"
                                                fill="#222222"></circle>
                                        <circle cx="8" cy="8" r="2" transform="rotate(90 8 8)"
                                                fill="#222222"></circle>
                                        <circle cx="8" cy="14" r="2" transform="rotate(90 8 14)"
                                                fill="#222222"></circle>
                                    </svg>
                                </button>

                            </div>
                        </div>
                        <div class="AdBody_conditionWrapper__2n8tu"><span
                                class="AdBody_condition__1bkGs">20 m² - 2 PN</span></div>
                        <div><span class="product__price">1,4 tỷ</span></div>
                    </div>
                    <div class="product__footer">
                        <a target="_blank">
                            <img
                                class="commonStyle_image__2y3kd commonStyle_round__3k7wj" height="16"
                                width="16"
                                src="https://static.chotot.com/storage/chotot-icons/svg/user.svg"
                                alt="Song Luân"></a>
                        <span>hôm qua</span>
                        <span>Hà Nội</span>
                    </div>
                </div>
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
<?php require 'footer.php' ?>
