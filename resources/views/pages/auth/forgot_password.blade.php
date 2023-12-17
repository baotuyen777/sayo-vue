@extends('layout.index')
@section('content')
    <div id="login-page">
        <progress hidden=""></progress>
        <div class=" login-wrapper">
            <div class="login-form error">
                <h1>Đặt lại mật khẩu</h1>

                <form method="post" action="{{route('password.email')}}">

                    @include('component.form.text',['name'=> 'to_send_password_change', 'label' => 'Email, Số điện thoại, User name',  'type' =>'text'])

                    <button class="btn btn--primary btn--large full btn-submit">Đặt lại mật khẩu</button>
                    @csrf
                </form>
            </div>
        </div>
    </div>
@endsection
