@extends('layout.index')

@section('content')
    <main>
        <div class="container">
            <div class="ct-detail adview">

                <div class="row base">
                    <div class="col-md-8">
                        @include('component.post-detail.slider')
                        <div class="AdDecription_adDecriptionWrapper____nLb">
                            <h1 class="AdDecription_adTitle__AG9r4"> {{$obj['name']}}</h1>
                            <div class="AdDecription_priceWrapper__ObnxA">
                                <div class="AdDecription_adPrice__MQzGw" itemprop="price">
                                    {{moneyFormat($obj['price'])}}
                                </div>
                                <button type="button" class="SaveAd_saveAdViewDetail__UGkS5">Lưu tin
                                    <img height="20" src="{{asset('/img/icon/heart.svg')}}" alt="like" loading="lazy"></button>
                            </div>

                            <p class="AdDecription_adBody__qp2KG" itemprop="description">{{$obj['content']}}</p>
                        </div>

                        <p class="">
                            <a href="tel:{{$obj->author->phone}}">{{$obj->author->phone}} BẤM ĐỂ GỌI</a>
                        </p>

                        <section class="grid-2">
                            <div class="align-center">
                                <i class="state-used"></i>
                                <span><b>Tình trạng:</b> <span>Đã sử dụng</span></span>
                            </div>
                            @if($obj['attr'])
                                @foreach($obj['attr'] as $field=>$attr)
                                    <div>
                                        <p class="align-center">
                                            <i class="product-type"></i>
                                            <span><b>{{$attr['label']}}</b>: {{$attr['valueLabel'] ?? ''}}</span>&nbsp;
                                        </p>
                                    </div>

                                @endforeach
                            @endif


                            {{--                                                        <div class="col-md-6 no-padding AdParam_adParamItem__Yi2I0" data-testid="param-item">--}}
                            {{--                                                            <div class="AdParam_adMediaParam__3epxo">--}}
                            {{--                                                                <div class="media-left media-top"><img class="AdParam_adParamIcon__m87Vj"--}}
                            {{--                                                                                                       alt="Chất liệu"--}}
                            {{--                                                                                                       src="https://static.chotot.com/storage/icons/logos/ad-param/product_material.png">--}}
                            {{--                                                                </div>--}}
                            {{--                                                                <div class="media-body media-middle"><span><span>Chất liệu: </span><span--}}
                            {{--                                                                            itemprop="product_material"--}}
                            {{--                                                                            class="AdParam_adParamValue__IfaYa">Nệm</span></span></div>--}}
                            {{--                                                            </div>--}}
                            {{--                                                        </div>--}}
                            {{--                                                        <div class="col-md-6 no-padding AdParam_adParamItem__Yi2I0" data-testid="param-item">--}}
                            {{--                                                            <div class="AdParam_adMediaParam__3epxo">--}}
                            {{--                                                                <div class="media-left media-top"><img class="AdParam_adParamIcon__m87Vj"--}}
                            {{--                                                                                                       alt="Thông tin sử dụng"--}}
                            {{--                                                                                                       src="https://static.chotot.com/storage/icons/logos/ad-param/usage_information.png">--}}
                            {{--                                                                </div>--}}
                            {{--                                                                <div class="media-body media-middle"><span><span>Thông tin sử dụng: </span><span--}}
                            {{--                                                                            itemprop="usage_information" class="AdParam_adParamValue__IfaYa">In trên bao bì</span></span>--}}
                            {{--                                                                </div>--}}
                            {{--                                                            </div>--}}
                            {{--                                                        </div>--}}
                        </section>
                        <section class="align-center">
                            <i class="location"></i><strong>Khu Vực:</strong>
                            <span>{{$obj->ward->name ?? ''}}, {{$obj->district->name ?? ''}}, {{$obj->province->name?? ''}}</span>
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

                    <div class="col-md-4">
                        @include('component.post-detail.sidebar')
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
