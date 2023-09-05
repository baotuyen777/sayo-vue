<div class="post-horizontal ctad ctNewAd newDashboardAd ctadPublished ">
    <div class="body card">
        <div class="img" style="background-image: url('{{($post['avatar']['url'] ?? '')}}')">
            {{--            <img src="{{($post['avatar']['url'] ?? '')}}" alt="{{$post['avatar']['name']}}">--}}
        </div>
        <div class="info">
                <p class="card__title"><a class="" href="{{editProductUrl($post)}}">{{$post['name']}}</a></p>
                <p class="card__price"><b>{{moneyFormat($post['price'])}}</b></p>
                <p class="datetime"><small>Đã đăng {{showHumanTime($post['created_at'])}}</small></p>
        </div>
    </div>

</div>
