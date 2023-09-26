@php
    $route =Route::currentRouteName()
@endphp
<div class="post-table">
    <form action="{{url()->current()}}">
        <div class="flex-row">
            @include('component.form.filter.selectCategory', ['options' => $categories,'route'=>$route])
            @include('component.form.filter.selectProvince', ['options' => $provinces,'route'=>$route])
            @if($province)
                @include('component.form.filter.selectDistrict', ['options' => $districts,'route'=>$route])
            @endif
            @if($district)
                @include('component.form.filter.selectWard', ['options' => $wards,'route'=>$route])
            @endif

            @include('component.form.filter.rangePrice')
            @include('component.form.filter.keyword')
        </div>

    </form>

    <table>
        <thead>
        <tr>
            <th>STT</th>
            <th>Avatar</th>
            <th>Tên</th>
            <th>Hành động</th>
        </tr>
        </thead>
        <tbody>
        @foreach($objs as $obj)
            <tr>
                <td>{{$loop->index+1}}</td>
                <td>
                    <div class="post-avatar" style="background-image: url('{{($obj['avatar']['url'] ?? '')}}')">
                        <label
                            class="{{$obj['status']==2?'success':''}}" {{\App\Models\Post::$statusClass[$obj['status']]}}>{{\App\Models\Post::$status[$obj['status']]}}</label>
                    </div>
                </td>
                <td valign="top">
                    <a href="{{route('postEdit',['slug'=>$obj['code']])}}">{{$obj->name}}</a>
                    <p>
                        <small>{{showHumanTime($obj->created_at)}}</small>
                        <span class="price">{{moneyFormat($obj->price)}}</span>
                    </p>
                </td>
                <td>
                    <div class="d-flex-wrap gap-10">
                        <button class="btn--small btn-ajax danger"
                                data-url="{{route('post.destroy',['post'=>$obj['code']])}}" data-method="delete">
                            Xóa
                        </button>
                        @if(Auth::user()->role===4)
                            <button class="btn--small btn-ajax danger"
                                    data-url="{{route('postUpdateSimple',['slug'=>$obj['code']])}}"
                                    data-param='{"status":4}'>
                                Ẩn
                            </button>
                        @endif
                        @if(Auth::user()->role===1)

                            @if($obj['status']!=2)
                                <button class="btn--small btn-ajax success"
                                        data-url="{{route('postUpdateSimple',['slug'=>$obj['code']])}}"
                                        data-param='{"status":2}'>
                                    Duyệt
                                </button>
                            @endif
                            @if($obj['status'] !=3)
                                <button class="btn--small btn-ajax warning"
                                        data-url="{{route('postUpdateSimple',['slug'=>$obj['code']])}}"
                                        data-param='{"status":3}'>Từ chối
                                </button>
                            @endif
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
    <span class="csrf hide">{{csrf_token()}}</span>
</div>
{{--<form action="{{route('postEdit',['slug'=>$post['code']])}}"></form>--}}
