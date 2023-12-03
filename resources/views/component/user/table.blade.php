@php
    $route =Route::currentRouteName();

@endphp
<div class="post-table">
    <form action="{{url()->current()}}">
        <div class="flex-row">
            {{--            @include('component.form.filter.selectProvince', ['options' => $provinces,'route'=>$route])--}}
            @if(isset($province))
                @include('component.form.filter.selectDistrict', ['options' => $districts,'route'=>$route])
            @endif
            @if(isset($district))
                @include('component.form.filter.selectWard', ['options' => $wards,'route'=>$route])
            @endif

            @include('component.form.filter.keyword')
        </div>

    </form>

    <table>
        <thead>
        <tr>
            <th>STT</th>
            <th>Avatar</th>
            <th>Thông tin</th>
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
                            class="{{$obj['status']==2?'success':''}}" {{\App\Models\Post::$statusClass[$obj['status']]}}>
                            {{\App\Models\Post::$status[$obj['status']]}}</label>
                    </div>
                </td>
                <td valign="top">
                    {{--                    <a href="{{route('user.edit',['user'=>$obj['code']])}}">{{$obj->name}}</a>--}}
                    <a href="{{ route('user.edit', ['user'=>$obj['username']]) }}">{{$obj['name']}}</a>
                    <p>

                        <small>{{showHumanTime($obj->created_at)}}</small>
                    </p>
                </td>
                <td>
                    <div class="d-flex-wrap gap-10">
                        <button class="btn--small btn-ajax danger"
                                data-url="{{route('user.destroy',['user'=>$obj['username']])}}" data-method="delete">
                            Xóa
                        </button>
                        @if($obj['status'] != STATUS_ACTIVE)
                            <button class="btn--small btn-ajax success"
                                    data-url="{{route('user.update',['user'=>$obj['username']])}}"
                                    data-param='{"status":2}'>
                                Duyệt
                            </button>
                        @endif
                        @if($obj['status'] != STATUS_DEACTIVATE)
                            <button class="btn--small btn-ajax warning"
                                    data-url="{{route('user.update',['user'=>$obj['username']])}}"
                                    data-param='{"status":3}'>Từ chối
                            </button>
                        @endif

                    </div>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
    <span class="csrf hide">{{csrf_token()}}</span>
    @include('component.list.pagination')
</div>
{{--<form action="{{route('postEdit',['code'=>$post['code']])}}"></form>--}}
