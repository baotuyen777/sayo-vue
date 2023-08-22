@extends('layout.index')

@section('content')
    <main>
        <div class="container">
            <div class="ct-detail adview">
                <ol class="breadcrumb">
                    <li><a href="https://www.chotot.com">Sayo</a></li>
                    <li>
                        <a href="https://www.chotot.com/mua-ban-ban-ghe"><span
                            >Bàn ghế</span></a></li>
                    <li>
                        <a href="https://www.chotot.com/mua-ban-ban-ghe-ha-noi"><span
                            >Bàn ghế Hà Nội</span></a></li>
                    <li>
                        <a href="https://www.chotot.com/mua-ban-ban-ghe-quan-nam-tu-liem-ha-noi"><span
                            >Bàn ghế Quận Nam Từ Liêm</span></a>
                    </li>
                    <li class="BreadCrumb_breadcrumbItem__M8Q4i" itemprop="itemListElement">
                        <span>ghế xoay mới 95%</span>
                    </li>
                </ol>

                <div class="row base">
                    <div class="col-md-8">
                        @include('component.post-detail.slider')
                        <div class="AdDecription_adDecriptionWrapper____nLb">
                            <h1 class="AdDecription_adTitle__AG9r4"> {{$obj['name']}}}</h1>
                            <div class="AdDecription_priceWrapper__ObnxA">
                                <div class="AdDecription_adPrice__MQzGw" itemprop="price">
                                    {{moneyFormat($obj['price'])}}
                                </div>
                                <button type="button" class="SaveAd_saveAdViewDetail__UGkS5"><p
                                        style="margin: 0px;">Lưu tin </p><img height="20" width="20"
                                                                              src="https://static.chotot.com/storage/icons/saveAd/save-ad.svg"
                                                                              alt="like" loading="lazy"></button>
                            </div>

                            <p class="AdDecription_adBody__qp2KG" itemprop="description">{{$obj['content']}}</p>
                        </div>

                        <div class="d-lg-block d-none">
                            <div class="InlineShowPhoneButton_wrapper__NtHmX">
                                <div
                                    class="InlineShowPhoneButton_linkContact__YEWbK InlineShowPhoneButton_phoneHidden__GJPGi">
                                    <span>Nhấn để hiện số: 097301 ***</span></div>
                            </div>
                        </div>

                        <div class="col-xs-12 no-padding">
                            <div class="col-md-6 no-padding AdParam_adParamItem__Yi2I0">
                                <div class="AdParam_adMediaParam__3epxo">
                                    <div class="media-left media-top"><img class="AdParam_adParamIcon__m87Vj"
                                                                           alt="Tình trạng"
                                                                           src="https://static.chotot.com/storage/icons/logos/ad-param/condition_ad.png">
                                    </div>
                                    <div class="media-body media-middle"><span><span>Tình trạng: </span><span
                                                class="AdParam_adParamValue__IfaYa">Đã sử dụng</span></span></div>
                                </div>
                            </div>
                            @if($obj['attr'])
                                @foreach(json_decode($obj['attr']) as $field=>$val)
                                    <div class="col-md-6 no-padding AdParam_adParamItem__Yi2I0 d-flex">
                                        <img class="AdParam_adParamIcon__m87Vj" alt="{{$field}}"
                                             src="https://static.chotot.com/storage/icons/logos/ad-param/product_type.png">
                                        <span>{{$field}}: </span>&nbsp;
                                        <span itemprop="product_type"
                                              class="AdParam_adParamValue__IfaYa"> {{$val}}</span>
                                    </div>
                                @endforeach
                            @endif

                            {{--                            <div class="col-md-6 no-padding AdParam_adParamItem__Yi2I0" data-testid="param-item">--}}
                            {{--                                <div class="AdParam_adMediaParam__3epxo">--}}
                            {{--                                    <div class="media-left media-top"><img class="AdParam_adParamIcon__m87Vj"--}}
                            {{--                                                                           alt="Chất liệu"--}}
                            {{--                                                                           src="https://static.chotot.com/storage/icons/logos/ad-param/product_material.png">--}}
                            {{--                                    </div>--}}
                            {{--                                    <div class="media-body media-middle"><span><span>Chất liệu: </span><span--}}
                            {{--                                                itemprop="product_material"--}}
                            {{--                                                class="AdParam_adParamValue__IfaYa">Nệm</span></span></div>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            {{--                            <div class="col-md-6 no-padding AdParam_adParamItem__Yi2I0" data-testid="param-item">--}}
                            {{--                                <div class="AdParam_adMediaParam__3epxo">--}}
                            {{--                                    <div class="media-left media-top"><img class="AdParam_adParamIcon__m87Vj"--}}
                            {{--                                                                           alt="Thông tin sử dụng"--}}
                            {{--                                                                           src="https://static.chotot.com/storage/icons/logos/ad-param/usage_information.png">--}}
                            {{--                                    </div>--}}
                            {{--                                    <div class="media-body media-middle"><span><span>Thông tin sử dụng: </span><span--}}
                            {{--                                                itemprop="usage_information" class="AdParam_adParamValue__IfaYa">In trên bao bì</span></span>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                        </div>
                        <section class="col-xs-12 no-padding">

                            <img class="AdParam_adParamIcon__m87Vj"
                                 alt="location"
                                 src="https://static.chotot.com/storage/icons/logos/ad-param/location.svg"><strong>Khu
                                Vực:</strong>
                            <span>Phường Xuân Phương, Quận Nam Từ Liêm, Hà Nội</span>

                        </section>


                        <section class="col-xs-12 no-padding">
                            <div class="IntersectBox " style="min-height: 100px;">
                                <div class="ChatTemplate_chatTempWrapper__uAELZ">
                                    <div class="ChatTemplate_titleChatTemp__IWGIA">Hỏi người bán qua chat</div>
                                    <div class="ChatTemplate_templateItemWrapper__AP8xV">
                                        <ul class="ChatTemplate_templateMessage__a_aks">
                                            <li class="ChatTemplate_templateItem__7p1c6" role="menuitem">Sản phẩm này
                                                còn không ạ?
                                            </li>
                                            <li class="ChatTemplate_templateItem__7p1c6" role="menuitem">Bạn có ship
                                                hàng không?
                                            </li>
                                            <li class="ChatTemplate_templateItem__7p1c6" role="menuitem">Sản phẩm này có
                                                còn bảo hành không?
                                            </li>
                                            <li class="ChatTemplate_templateItem__7p1c6" role="menuitem">Chất liệu sản
                                                phẩm là gì vậy ạ?
                                            </li>
                                            <li class="ChatTemplate_templateItem__7p1c6" role="menuitem">Bạn có các sản
                                                phẩm khác tương tự?
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </section>
                        @include('component.post-detail.report')
                    </div>

                    <div class="col-md-4 no-padding dtView">
                        @include('component.post-detail.sidebar')
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
