<div class="post-horizontal ctad ctNewAd newDashboardAd ctadPublished ">
    <div class="ctadBody">
        <div class="ctadImage"><img
                src="{{($post['avatar']['url'] ?? '')}}"
                alt=" " class="lazy">
            <div class="imageNumber">2</div>
            <i class="ctadSelectIcon ctadSelectIconNormal"></i></div>
        <div class="ctadInfo">
            <div class="upperBlock upperBlockLayout upperBlockLayoutWithExpiredDate">
                <div class="ctadWrapper">
                    <div class="ctadTitle"><a class="title"
                                              href="{{editProductUrl($post)}}">{{$post['name']}}</a></div>
                    <div class="">
                        <div class="">
                            <div class="ctadPrice ctadPriceWithExpiredDate">
                                <span><b>{{moneyFormat($post['price'])}} đ</b></span></div>
                            <div class="addinBlock addinBlockWithExpiredDate">
                                <div><span class="ctadDate listTime">Đã đăng {{$post['created_at']}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{--                                        <div class="ctadMenu ">--}}
                {{--                                            <div id="dropdownAd149442150">--}}
                {{--                                                <div class="buttonMenu"><img--}}
                {{--                                                        src="https://static.chotot.com/storage/react-common/listmenu.svg"--}}
                {{--                                                        alt=" "></div>--}}
                {{--                                            </div>--}}
                {{--                                        </div>--}}
            </div>
        </div>
    </div>
    <div class="bottomAdInfo">
        <div class="bottomPremiumFeature bottomPremiumFeatureWithExpiredDate">
            <div class="ctDashboardAdStatsPosition">
                <div class="ctAdStatsPositionBox">
                    <div class="ctAdPositionPageInfo">
                        <div class="ctAdPositionPageInfoWrapper"
                             id="ctAdPositionPageInfo-mobile_149442150"
                             style="left: -5%; color: rgb(88, 159, 57);">
                            <span>Trang 4</span>
                        </div>
                        <div class="icPosition" id="icPosition-mobile_149442150"
                             style="left: -2px; color: rgb(88, 159, 57);"></div>
                    </div>
                    <div class="ctAdPostionPageBar"></div>
                </div>
            </div>
            <div class="premiumButton "><a class="btn"><img class="icSellFaster"
                                                            src="https://static.chotot.com/storage/chotot-icons-me/ic-sell-faster.svg">Bán
                    nhanh hơn</a></div>
        </div>
    </div>
</div>
