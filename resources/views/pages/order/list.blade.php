@extends('layout.manager')

@section('content')
    <section class="card">
        @include('component.order.table')
    </section>

    @include('component.list.pagination')
@endsection
