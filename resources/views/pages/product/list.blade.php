@extends('layout.seller')

@section('content')
    <section class="card">
        @include('component.product.table')
    </section>

    @include('component.list.pagination')
@endsection
