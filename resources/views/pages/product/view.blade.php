@extends('layout.index')
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
          integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@section('content')
    <main class="post-detail">
        <div class="container">
            <div class="ct-detail adview">
                <div class="row">
                    <div class="col-md-8">
                        @include('component.post-detail.slider')
                        <div class="post-detail">
                            <h1 class="post-title"> {{$obj['name']}}</h1>
                            <div class="ad-price-wrapper">
                                <div class="ad-adPrice" itemprop="price">
                                    {{moneyFormat($obj['price'])}}
                                </div>
                                <button type="button" class="btn--oval">Lưu tin
                                    <img height="20" src="{{asset('/img/icon/heart.svg')}}" alt="like"></button>
                                <form @class('form-ajax') data-confirm="Bạn có chắc chắn muốn đặt hàng"
                                      action="{{ route('order.store',['product_code' => $obj['code']]) }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn--oval">Đặt hàng
                                        <img height="20" src="{{asset('/img/icon/cart.svg')}}" alt="cart"></button>
                                </form>
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


                        @include('component.post-detail.report')
                        @include('component.review.index')
                    </div>

                    <div class="col-md-4">
                        @include('component.post-detail.sidebar')
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('js')
    <script>
        $( document ).ready(function() {
            $( ".open" ).click(function() {
                $( "#blackout" ).addClass( "visable" );
                $( "#popup" ).addClass( "visable" );
            });
            $( "#blackout, .close" ).click(function() {
                $( "#blackout" ).removeClass( "visable" );
                $( "#popup" ).removeClass( "visable" );
            });
        });
    </script>
@endpush
