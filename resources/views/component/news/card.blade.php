@php
    $detailLink =  route('newsView',['slug'=>$obj['code']]);
    $bg= $obj['avatar']['url'] ?? $obj['avatar_link'] ?? asset('img/sayo-default-vertical.webp');
@endphp

<div class="card card--product">
    <a href="{{$detailLink}}">
        <div class="avatar" style="background: url({{$bg}})"></div>
    </a>
    <h3><a href="{{$detailLink}}">{{$obj['name']}}</a></h3>
</div>
