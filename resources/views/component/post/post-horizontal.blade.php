<div class="post-horizontal ctad ctNewAd newDashboardAd ctadPublished ">
    <div class="ctadBody">
        <div class="ctadImage" style="background-image: url('{{($post['avatar']['url'] ?? '')}}')">
{{--            <img src="{{($post['avatar']['url'] ?? '')}}" alt="{{$post['avatar']['name']}}">--}}
        </div>
        <div class="ctadInfo">
            <div class="upperBlock upperBlockLayout upperBlockLayoutWithExpiredDate">
                <div class="ctadWrapper">
                    <div class="ctadTitle">
                        <a class="title" href="{{editProductUrl($post)}}">{{$post['name']}}</a></div>

                    <div class="ctadPrice ctadPriceWithExpiredDate">
                        <span><b>{{moneyFormat($post['price'])}} đ</b></span></div>
                    <div class="addinBlock addinBlockWithExpiredDate">
                        <div>
                            <span class="ctadDate listTime">Đã đăng {{$post['created_at']}}</span>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
