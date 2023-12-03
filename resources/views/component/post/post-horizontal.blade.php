<div class="post-horizontal">
    <div class="body card">
        <div class="img" style="background-image: url('{{($post['avatar']['url'] ?? '')}}')"></div>
        <div class="info">
            <p class="card__title"><a class=""
                                      href="{{route($routeName ?? 'postEdit',['catCode'=>$post['category']['code'],'code'=>$post['code']])}}">{{$post['name']}}</a>
            </p>
            <p class="card__price"><b>{{moneyFormat($post['price'])}}</b></p>
            <p class="datetime"><small>Đã đăng {{showHumanTime($post['created_at'])}}</small></p>
        </div>
    </div>
    <div
        class="product-label {{\App\Models\Post::$statusClass[$post['status']]}}">{{\App\Models\Post::$status[$post['status']]}}</div>
</div>
