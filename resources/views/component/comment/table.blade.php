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
            <th>Người bình luận</th>
            <th>Bài viết</th>
            <th>Bình luận</th>
            <th>Hành động</th>
        </tr>
        </thead>
        <tbody>
        @foreach($objs as $obj)
            <tr>
                <td>{{$loop->index+1}}</td>
                <td valign="top">
                    {{--                    <a href="{{route('user.edit',['user'=>$obj['code']])}}">{{$obj->name}}</a>--}}
                    <p>{{$obj['user']['name']}}</p>
                </td>
                <td valign="top">
                    {{--                    <a href="{{route('user.edit',['user'=>$obj['code']])}}">{{$obj->name}}</a>--}}
                    <p>{{$obj['post']['name']}}</p>
                </td>
                <td valign="top">
                    {{--                    <a href="{{route('user.edit',['user'=>$obj['code']])}}">{{$obj->name}}</a>--}}
                    <p>{{$obj['content']}}</p>
                    <p>
                        <small>{{showHumanTime($obj->created_at)}}</small>
                    </p>
                </td>
                <td>
                    <div class="d-flex-wrap gap-10">
                   <button class="btn--small btn-ajax danger"
                                data-url="{{ route('comment.destroy', $obj->id) }}" data-method="delete">
                            Xóa
                        </button>
                        @if($obj['status'] != STATUS_ACTIVE)
                            <button class="btn btn--small btn-ajax success"
                                    data-url="{{ route('comment.update', $obj->id) }}"
                                    data-param='{"status":2}'>
                                Duyệt
                            </button>
                        @endif
                        @if($obj['status'] != STATUS_DEACTIVATE)
                            <button class="btn btn--small btn-ajax warning"
                                    data-url="{{ route('comment.update', $obj->id) }}"
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
{{--<form action="{{route('postEdit',['slug'=>$post['code']])}}"></form>--}}
