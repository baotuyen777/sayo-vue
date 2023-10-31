@extends('layout.index')
@section('content')
    <main class="post-detail">
        <div class="container">
            <div class="ct-detail adview">

                <div class="row base">
                    <div class="col-md-8">
                        @include('component.post-detail.slider')
                        <div class="ad-image-wrapper">
                            <h1 class="post-title"> {{$obj['name']}}</h1>
                            <div class="ad-price-wrapper">
                                <div class="ad-adPrice" itemprop="price">
                                    {{moneyFormat($obj['price'])}}
                                </div>
                                <button type="button" class="btn--oval">Lưu tin
                                    <img height="20" src="{{asset('/img/icon/heart.svg')}}" alt="like"></button>
                            </div>

                            <div class="post-detail__content" itemprop="description">{!! $obj['content'] !!}</div>
                        </div>

                        <p class="">
                            <a href="tel:{{$obj->author->phone}}"> BẤM ĐỂ GỌI: {{$obj->author->phone}}</a>
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
                        </section>

                        <section class="col-xs-12 no-padding">
                            <div class="IntersectBox " style="min-height: 100px;">
                                <div class="ChatTemplate_chatTempWrapper__uAELZ">
                                    <div class="chat-titleChatTemp">Hỏi người bán qua chat</div>
                                    <div class="ChatTemplate_templateItemWrapper__AP8xV">
                                        <ul class="chat_templateMessage">
                                            <li class="chat-templateItem" role="menuitem">Sản phẩm này
                                                còn không ạ?
                                            </li>
                                            <li class="chat-templateItem" role="menuitem">Bạn có ship
                                                hàng không?
                                            </li>
                                            <li class="chat-templateItem" role="menuitem">Sản phẩm này có
                                                còn bảo hành không?
                                            </li>
                                            <li class="chat-templateItem" role="menuitem">Chất liệu sản
                                                phẩm là gì vậy ạ?
                                            </li>
                                            <li class="chat-templateItem" role="menuitem">Bạn có các sản
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
