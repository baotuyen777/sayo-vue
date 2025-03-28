<main>
    @php
    dd($category);
    @endphp
    @section('sidebar')
        <div class="card">
            <h3>Danh mục</h3>
            <ul class="category-list">
                @foreach(getCategories($category['code']) as $category)
                    <li>
                        <a href="{{route('archive',['catCode'=>$category["code"]])}}">
                            {{ $category['name'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endsection
    @include('component.form.filter.index')
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

