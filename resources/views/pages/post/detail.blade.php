@extends('layout.index')

@section('content')
    <main class="container">
        <livewire:post.post-form :code="$obj['code'] ?? null" />
    </main>
@endsection
