@extends('layout/index')

@section('content')
    <main>
        <section>
            <div class="container">
                <div class="card">
                    <h2>{{'Gái xinh việt nam'}}</h2>
                    <div class="d-flex-wrap grid-3">
                        @foreach($objs as $obj)
                            @include('component.news.card',['obj'=> $obj])
                        @endforeach
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
