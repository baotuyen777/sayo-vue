@extends('layout.index')
@php    $location = array_filter([$obj->ward->name?? null ,$obj->district->name ?? null ,$obj->province->name?? null]);
if($obj->address){
    array_unshift($location,$obj->address);
}
@endphp
@section('content')
    <main class="post-detail">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @include('component.post-detail.slider')
                    <h1 class="post-title111"> {{$obj['name']}}</h1>
                    <div class="ad-price-wrapper">
                        <div class="ad-adPrice" itemprop="price">
                            {{moneyFormat($obj['price'])}}
                        </div>
                        <button type="button" class="btn--oval">Lưu tin
                            <img height="20" src="{{asset('/img/icon/heart.svg')}}" alt="like"></button>
                    </div>

                    <div class="post-detail__content">{!! $obj['content'] !!}</div>

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
                    <section class="align-center">
                        <i class="location"></i><strong>Khu Vực:</strong>
                        <span>{{$location ? implode(', ',$location) : ''}}</span>
                    </section>
                    @include('component.post-detail.report')
                    @include('component.comment.index')
                </div>

                <div class="col-md-4">
                    @include('component.post-detail.sidebar')
                    <section class="chat-template">
                        <h4>Hỏi người bán qua chat</h4>
                        <ul>
                            <li>Sản phẩm này còn không ạ?</li>
                            <li>Bạn có ship hàng không?</li>
                            <li>Sản phẩm này có còn bảo hành không?</li>
                            <li>Chất liệu sản phẩm là gì vậy ạ?</li>
                            <li>Bạn có các sản phẩm khác tương tự?</li>
                        </ul>
                    </section>
                </div>
            </div>
        </div>
    </main>
@endsection
