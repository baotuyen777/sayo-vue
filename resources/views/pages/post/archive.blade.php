@extends('layout/index')

@section('content')
    <main>
        <section class="container">
            <form action="{{url()->current()}}">
                <div class="flex-row">
                    @include('component.form.filter.selectCategory', ['options' => $categories])
                    @include('component.form.filter.selectProvince', ['options' => $provinces])
                    @if($province)
                        @include('component.form.filter.selectDistrict', ['options' => $districts])
                    @endif
                    @if($district)
                        @include('component.form.filter.selectWard', ['options' => $wards])
                    @endif

                    @include('component.form.filter.rangePrice')
                    @include('component.form.filter.keyword')
                </div>

            </form>

        </section>
        <section>
            <div class="container">
                <div class="card">
                    <h2>{{$category['name'] ?? 'Tất cả danh mục'}}</h2>
                    <div class="d-flex-wrap grid-6">
                        @foreach($objs as $obj)
                            @include('component.post.post_card',['obj'=> $obj])
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
