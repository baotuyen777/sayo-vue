<div class="post-horizontal">
    <div class="body card">
        <div class="img" style="background-image: url('{{($product['avatar']['url'] ?? '')}}')"></div>
        <div class="info">
            <p class="card__title"><a class=""
                                      href="{{route('productEdit',['code'=>$product['code']])}}">{{$product['name']}}</a></p>
            <p class="card__price"><b>{{moneyFormat($product['price'])}}</b></p>
            <p class="datetime"><small>Đã đăng {{showHumanTime($product['created_at'])}}</small></p>
        </div>
    </div>
    <div
        class="post-label {{\App\Models\Product::$statusClass[$product['status']]}}">{{\App\Models\Product::$status[$product['status']]}}</div>
</div>
