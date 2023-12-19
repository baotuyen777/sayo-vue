@extends('layout.seller')

@section('content')
    <section class="card">
        @include('component.order.table')
    </section>

    @include('component.list.pagination')
@endsection
