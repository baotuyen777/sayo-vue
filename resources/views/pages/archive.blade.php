@extends('layout/index')

@section('content')
    <main>
        <section class="white-box p-10 container d-flex gap-10">
            @include('component.form.selectProvince', ['options' => $provinces,'first'=>'Toàn quốc', 'obj'=> $category])
            @include('component.form.select5', ['options' => $districts,'first'=>'Tất cả', 'obj'=> $category])
            @include('component.form.selectWard', ['options' => $wards,'first'=>'Tất cả', 'obj'=> $category])
        </section>
        <section>
            <div class="container">
                <div class="card">
                    <h2>{{$category['name']}}</h2>
                    <div class="d-flex-wrap grid-6">
                        @foreach($posts as $post)
                            @include('component.post',['obj'=> $post])
                        @endforeach
                    </div>
                </div>
                <div class="p-10">
                    <a class="view-more">Xem thêm <i id="arrowIcon" class="fa fa-angle-down"></i></a>
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
