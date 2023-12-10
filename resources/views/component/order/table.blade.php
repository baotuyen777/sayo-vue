@php
    $route =Route::currentRouteName()
@endphp
<div class="post-table">
    <form action="{{url()->current()}}">
        <div class="flex-row">
            @include('component.form.filter.selectCategory', ['options' => $categories,'route'=>$route])
            @include('component.form.filter.rangePrice')
            @include('component.form.filter.keyword')
            <a class="btn btn--primary" href="{{route('createProduct')}}" rel="nofollow">Add Product</a>
        </div>
    </form>
    <div style="float: right">
        <p style="color: red">Doanh thu: {{ $totalPrice }}</p>
    </div>
    <table>
        <thead>
        <tr>
            <th>STT</th>
            <th>Tên khách hàng</th>
            <th>Email</th>
            <th>Số điện thoại</th>
            <th>Tên sản phẩm</th>
            <th>Dơn giá</th>
            <th>Hành động</th>
        </tr>
        </thead>
        <tbody>
        @foreach($objs as $obj)
            <tr>
                <td>{{$loop->index+1}}</td>
                <td>
                    {{ $obj->author->name }}
                    <div class="post-avatar">
                        <label
                            class="{{$obj['status']==STATUS_COMPLETED ?'success':''}}" {{\App\Models\Orders::$statusOrder[$obj['status']]}}>{{\App\Models\Orders::$statusOrder[$obj['status']]}}</label>
                    </div>
                </td>
                <td>
                    {{ $obj->author->email }}
                </td>
                <td>
                    {{ $obj->author->phone }}
                </td>
                <td valign="top">
                    {{ $obj->product->name }}
                </td>
                <td valign="top">
                    {{ $obj->product->price }}
                </td>
                <td>
                    <div class="d-flex-wrap gap-10">
                        @if(Auth::user()->role===ROLE_ADMIN || Auth::user()->id == $obj->seller_id)
                            <button class="btn--small btn-ajax danger"
                                    data-url="{{route('order.destroy', $obj['id'])}}" data-method="delete">Xóa
                            </button>
                            @if($obj['status'] != STATUS_ORDERED)
                                <button class="btn--small btn-ajax warning"
                                        data-url="{{route('order.updateSimple', $obj['id'])}}"
                                        data-param='{"status":{{ STATUS_PROCESSING }}}' >Đã đặt hàng
                                </button>
                            @endif
                            @if($obj['status'] != STATUS_PROCESSING)
                                <button class="btn--small btn-ajax"
                                        data-url="{{route('order.updateSimple', $obj['id'])}}" data-param='{"status":{{ STATUS_PROCESSING }}}'>
                                    Đang xử lý
                                </button>
                            @endif
                            @if($obj['status'] != STATUS_COMPLETED)
                                <button class="btn--small btn-ajax success"
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
