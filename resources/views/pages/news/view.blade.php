@extends('layout.index')

@section('content')
    <main>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <section class="white-box p-10">
                        <h1>{{$obj['name']}}</h1>

                        <div>
                            {!! $obj->content !!}
                        </div>
                    </section>


                </div>

                <div class="col-md-4">
                    {{--                    @include('component.post-detail.sidebar')--}}
                </div>
            </div>
        </div>
    </main>
@endsection
