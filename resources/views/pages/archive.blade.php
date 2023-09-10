@extends('layout/index')

@section('content')
    <main>
        <section class="white-box p-10 container d-flex gap-10">
            @include('component.form.selectProvince', ['options' => $provinces,'first'=>'Toàn quốc'])
            @if($province)
                @include('component.form.selectDistrict', ['options' => $districts,'first'=>'Tất cả'])
            @endif
            @if($district)
                @include('component.form.selectWard', ['options' => $wards,'first'=>'Tất cả'])
            @endif

        </section>
        <section>
            <div class="container">
                <div class="card">
                    <h2>{{$category['name']}}</h2>
                    <div class="d-flex-wrap grid-6">
                        @foreach($objs as $obj)
                            @include('component.post',['obj'=> $obj])
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
