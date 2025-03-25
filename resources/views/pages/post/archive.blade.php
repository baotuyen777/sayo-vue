@extends('layout/index')

@section('content')
    @php
//        dd($objs);
    @endphp
    <main>
        @include('component.form.filter.index')
        <section>
            <div class="container">
                <div class="card">
                    <h2>{{$category['name'] ?? 'Tất cả danh mục'}}</h2>
                    <div class="d-flex-wrap grid-6">
                        @if($objs->isEmpty())
                            <p>Không có dữ liệu.</p>
                        @else
                            @foreach($objs as $obj)
                                @include('component.post.post_card',['obj'=> $obj])
                            @endforeach
                        @endif
                    </div>
                    @include('component.list.pagination')
                </div>
            </div>
        </section>

        <section>
            <div class="container ">
                <div class="card">
                    <h2>Các từ khóa phổ biến</h2>
                    <ul>
                        <li><a href="#">Samsung Note 10</a></li>
                    </ul>
                </div>
            </div>
        </section>
    </main>

@endsection
