@extends('layout.index')

@section('content')
    <div class="container white-box">
        <div class="page_view_wrapper clearfix" style="text-align: center; margin-top: 20px;">
            <h1 class="title cl-red page-h1">Hệ thống đã gửi link xác nhận vào email của ban</h1>
        </div>

        <div class="page_404_content" style="text-align: center;">
            <p>vui lòng kiểm tra email: <span style="color: blue">{{ $email }}</span></p></div>
    </div>

@endsection
