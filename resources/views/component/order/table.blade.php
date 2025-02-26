@php
    $route =Route::currentRouteName();
    $status = App\Models\Orders::$status;
@endphp
<div class="post-table">
    <form action="{{url()->current()}}">
        <div class="flex-row">
            @include('component.form.filter.selectCategory', ['options' => $categories,'route'=>$route])
            @include('component.form.filter.keyword')
            @include('component.form.filter.rangeDate')
            <a class="btn btn--primary" href="{{route('order.create')}}" rel="nofollow">Lên đơn</a>
        </div>
    </form>
    <div style="float: right">
        <p style="color: red">Doanh thu: {{ moneyFormat($totalPrice) }}</p>
    </div>
    <table>
        <thead>
        <tr>
            <th>STT</th>
            <th>Khách hàng</th>
            <th>Tên sản phẩm</th>
            <th>Đơn giá</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
        </thead>
        <tbody>
        @foreach($objs as $obj)
            <tr>
                <td>{{$loop->index+1}}</td>
                <td>
                    <div><a href="{{route('order.show',['order'=>$obj->code])}}">#{{$obj->code}}</a></div>
                    {{ $obj->author->name }}
                    {{--                    <div class="post-avatar">--}}
                    {{--                        <label--}}
                    {{--                            class="{{$obj['status']==STATUS_COMPLETED ?'success':''}}" {{\App\Models\Orders::$statusOrder[$obj['status']]}}>{{\App\Models\Orders::$statusOrder[$obj['status']]}}</label>--}}
                    {{--                    </div>--}}
                    <div>{{ $obj->author->email }}</div>
                    <div>{{ $obj->author->phone }}</div>
                </td>

                <td>{{ $obj->product->name }}</td>
                <td>{{ moneyFormat($obj->price) }}</td>
                <td>{{ App\Models\Orders::$status[$obj->status] }}</td>
                <td>
                    <div class="d-flex-wrap gap-10">
                        @if(Auth::user()->role===ROLE_ADMIN || Auth::user()->id == $obj->seller_id)
                            @if(Auth::user()->role===ROLE_ADMIN)
                                <button class="btn btn--small btn-ajax danger"
                                        data-url="{{route('order.destroy', $obj['id'])}}" data-method="delete">Xóa
                                </button>
                            @endif
                            @if($obj->status == STATUS_COMPLETED)
                                <button class="btn btn--small btn-ajax"
                                        data-url="{{route('order.updateSimple', $obj['id'])}}"
                                        data-param='{"status":{{ STATUS_ORDERED }}}'>
                                    Reset
                                </button>
                            @endif

                            @if($obj->status == STATUS_ORDERED)
                                <button class="btn btn--small btn-ajax"
                                        data-url="{{route('order.updateSimple', $obj['id'])}}"
                                        data-param='{"status":{{ STATUS_PROCESSING }}}'>
                                    Đang xử lý
                                </button>
                            @endif
                            @if($obj->status != STATUS_COMPLETED)
                                <button class="btn      btn--small btn-ajax "
                                        data-url="{{route('order.updateSimple', $obj['id'])}}"
                                        data-param='{"status":{{ STATUS_COMPLETED }}}'>
                                    Đã hoàn thành
                                </button>
                            @endif
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
    <span class="csrf hide">{{csrf_token()}}</span>
</div>
{{--<form action="{{route('productEdit',['code'=>$product['code']])}}"></form>--}}
