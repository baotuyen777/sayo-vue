<div class="slider">
    <div class="group-slider">
        @foreach($obj['files'] as $i => $img)
            <div class="slider-item" data-image-index="{{$i}}">
                <img alt="{{$obj['name']}}" class="image-item" src="{{asset('storage/'.$img['url'])}}">
            </div>
        @endforeach
        @if($obj->author)
                <div class="slider-item">
                    <div class="lead-button-slide-wrapper">
                        <a class=" lead-button-default " href="tel:{{$obj->author->phone}}"> <img
                                src="{{asset('img/icon/call-green.png')}}" alt="call">Gọi điện</a>
                        <a class=" lead-button-default " href="sms:{{$obj->author->phone}}"><img
                                src="{{asset('img/icon/sms.png')}}" alt="sms">SMS</a>
                        <a class=" lead-button-default"
                           href="https://zalo.me/{{$obj->author->phone}}"
                           target="_blank" rel="nofollow"><img src="{{asset('img/icon/chat.png')}}" alt="chat">Chat</a>
                    </div>
                </div>
        @endif

    </div>
    <div class="navigator">
        @foreach($obj['files'] as $i => $img)
            <span data-id="{{$i}}" @class(['active'=>$i==0])></span>
        @endforeach
        <span data-id="n"></span>
    </div>
    <button class="slider__direction ad-image-prev" type="button"><i></i></button>
    <button class="slider__direction ad-image-next" type="button"><i></i></button>
    <div class="ad-image-caption">
        <span class="ad-image-caption-text">Đăng {{showHumanTime($obj['created_at'])}}</span>
    </div>
</div>
