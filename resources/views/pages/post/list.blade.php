@extends('layout.seller')

@section('content')
    <section class="card">
        @include('component.post.table')
    </section>

    @include('component.list.pagination')
@endsection
