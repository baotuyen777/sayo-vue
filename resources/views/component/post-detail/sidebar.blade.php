<div class="post-sidebar">
        {{--        <div class="NextAds_buttonWraper__oSIaL d-lg-block ">--}}
        {{--            <a href="{{route('archive')}}" class="NextAds_preAds__FsxYM" type="button">Về danh sách</a>--}}
        {{--            <button class="NextAds_nextAds__pn7aA" type="button">Tin Tiếp</button>--}}
        {{--        </div>--}}
        <div class="seller-profile ">
            <a class="SellerProfile_sellerWrapper__GlDwe" target="_blank" rel="nofollow"
               href="{{route('user.show',['user'=>$obj->author->username])}}">
                <div
                    class="img-thumbnail img-circle Avatar_imageWrapper__6tGNZ Avatar_defaultSize__a_WTh"></div>
                <div class="SellerProfile_nameBounder__btDeS" role="button" tabindex="0">
                    <div class="SellerProfile_flexDiv__IEgQl">
                        <div class="SellerProfile_nameDiv__sjPxP">
                            <b>{{$obj->author->name ?? "Khách"}} </b></div>
                        <button type="button" class="SellerProfile_secondaryButton__qJNPr">
                            Xem trang
                        </button>
                    </div>
                    <div class="SellerProfile_statusOnlineDiv__iiwUQ">
                        <div class="SellerProfile_offlineBullet__by5mZ">•</div>
                        Hoạt động 1 giờ trước
                    </div>
                </div>
            </a>
            <div class="SellerProfile_inforWrapper__KXg71">
                <div class="SellerProfile_inforItem__B3Pzq">
                    <div class="SellerProfile_inforText__D7tPA"><p>Cá nhân</p><span
                            class="SellerProfile_inforValue__hK4rb"><img
                                src="https://static.chotot.com/storage/chotot-icons/png/private-grey-icon.png"
                                alt="icon-canhan"
                                height="20px"></span>
                    </div>
                </div>
                <div class="SellerProfile_seperateLine__H_bJa"></div>
                <div class="SellerProfile_seperateLine__H_bJa"></div>
                <div class="SellerProfile_inforItem__B3Pzq">
                    <div class="SellerProfile_inforText__D7tPA"><p>Phản hồi chat</p><span
                            class="SellerProfile_inforValue__hK4rb">---</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="LeadButton_wrapperLeadButtonDesktop__SVKE8">
            <div class="LeadButton_showPhoneButton__1BIwH">
                <div class="ShowPhoneButton_wrapper__B627I ">
                    <div
                        class="ShowPhoneButton_phoneButton__p5Cvt ShowPhoneButton_phoneNotClicked__dlQn_">
                        <div class="ShowPhoneButton_flexDiv__3qpNj">
                            <span>
                                <img alt="phone-icon" class="ShowPhoneButton_icon__wsnZ5"
                                     src="{{asset('img/icon/white-phone.svg')}}">{{$obj->author->phone}}</span>&nbsp;&nbsp;
                            <a href="tel:{{$obj->author->phone}}">BẤM ĐỂ GỌI</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="LeadButton_chatDesktopButton__HSQyg"><a
                    href="https://zalo.me/{{$obj->author->phone}}"
                    rel="nofollow" class="btn LeadButton_buttonChatDesktop__gbYM9" target="_blank">
                    <img src="https://static.chotot.com/storage/chotot-icons/png/chat_green.png"
                         alt="chat"><span>CHAT VỚI NGƯỜI BÁN</span></a></div>
            <div><a href="#" rel="nofollow" class="btn LeadButton_buttonChatDesktop__gbYM9">
                    <span>Mua ngay</span></a></div>
        </div>

        <div class="d-lg-block">
            <div class="SafeTips_SafeTipsWrapper___i5Fm">
                <img alt="safe tips"
                     class="pull-left" width="100"
                     src="{{ asset('/img/mua-ban.png') }}">
                <div class="SafeTips_TipText__mMXwX"><p>Hẹn gặp ở nơi công cộng và quen thuộc khi giao dịch.</p></div>
            </div>

        </div>
</div>
