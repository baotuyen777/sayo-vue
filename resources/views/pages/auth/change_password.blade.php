@extends('layout.index')
@section('content')
    <div id="login-page">
        <progress hidden=""></progress>
        <div class=" login-wrapper">
            <div class="login-form">
                <h1>Đổi mật khẩu</h1>

                <form method="post" action="{{route('password.doReset', $token)}}">

                    @include('component.form.text',['name'=> 'password', 'label' => 'Passwrord',  'type' =>'password'])
                    @include('component.form.text',['name'=> 'password_confirmation', 'label' => 'Confirm password', 'type' =>'password'])

                    <button class="btn btn--primary btn--large full btn-submit">Đổi mật khẩu</button>
                    @csrf
                </form>
            </div>
        </div>
    </div>
@endsection
