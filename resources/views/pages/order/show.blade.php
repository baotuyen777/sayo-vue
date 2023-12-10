@extends('layout.index')
@section('content')
    @php
        $statuses = App\Models\Orders::$status
    @endphp
    <div class="container ">
        <section class="card">
            <h2>Đơn hàng: #{{$obj->code}}</h2>
            <div class="card__body ">
                <p>Sản phẩm: {{$obj->product->name}}</p>
                <p>Giá: {{moneyFormat($obj->price)}}</p>
                <p>Thời gian: {{showHumanTime($obj->created_at)}}</p>
                <p>Trạng thái: {{$statuses[$obj->status] ?? ''}}</p>
            </div>
        </section>

        <a class="btn btn--primary" href="{{route('order.index')}}">Danh sách đơn đã đặt</a>
    </div>

@endsection
