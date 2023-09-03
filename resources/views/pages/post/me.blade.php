@extends('layout.manager')

@section('content')
    <div class="d-flex-wrap grid-2">
        @foreach($posts as $post)
            @include('component.post.post-horizontal',['post' => $post])
        @endforeach

    </div>
@endsection
