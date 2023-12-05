@extends('layout.index')

@section('content')
    <div class="container white-box">
        <div class="page_view_wrapper clearfix" style="text-align: center; margin-top: 20px;">
            <h1 class="title cl-red page-h1">Thanh you</h1>
        </div>

        <div class="page_404_content" style="text-align: center;">
            <p>Bạn có thể <a href="/"> click vào đây </a>để quay lại <a href="/">Trang chủ</a></p></div>
        <section class="card">
            <div class="post-table">
                <table>
                    <thead>
                    <tr>
                        <th>Tên</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $total = 0;
                    @endphp
                    @foreach($objs->orders as $obj)
                        @php
                            $total += $obj->product->price;
                        @endphp
                        <tr>
                            <td>{{ $obj->product->name }}</td>
                            <td>1</td>
                            <td>{{ $obj->product->price }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td style="text-align: center; color: red">Tổng</td>
                        <td colspan="2" style="text-align: center;" >{{ $total }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>

@endsection
