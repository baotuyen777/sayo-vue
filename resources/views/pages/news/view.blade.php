@extends('layout.index')

@section('content')
    <main>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <section class="white-box p-10">
                        <h1>{{$obj['name']}}</h1>
                        <div><span class="posted-on">Cập nhật lần cuối <time>{{Carbon\Carbon::parse($obj->updated_at)->format('d-m-Y')}}</time></span><span
                                class="byline"> bởi <span class="meta-author vcard">{{$obj->author->name ?? 'David'}}</span></span>
                        </div>
                        <div>
                            {!! $obj->content !!}
                        </div>
                    </section>


                </div>

                <div class="col-md-4">
                    {{--                    @include('component.post-detail.sidebar')--}}
                </div>
            </div>
            <div class="card">
                <h2>{{'Có thể bạn quan tâm'}}</h2>
                <div class="d-flex-wrap grid-3">
                    @foreach($objs as $obj)
                        @include('component.news.card',['obj'=> $obj])
                    @endforeach
                </div>

            </div>
        </div>
    </main>
@endsection
