<div class="post-slider">
    <div class="slick-slider slick-initialized" dir="ltr">
        <div class="slick-track">
            <div class="slider">
                <div class="group-slider">
                    @foreach($obj['files'] as $i => $img)
                    <div class="silder-item" id-image="{{$i + 1}}">
                        <img alt="{{$obj['name']}}" class="image-item" src="{{$img['url']}}">
                    </div>
                    @endforeach
                    <div class="silder-item">
                        <div class="ad-slider-image">
                            <div class="ad-image-slider">
        
                            </div>
                            <div class="lead-button-slide-wrapper">
                                <a class=" lead-button-default " href="tel:{{$obj->author->phone}}"> <img
                                        src="https://static.chotot.com/storage/chotot-icons/png/call-green.png"
                                        alt="call">Gọi điện</a>
                                <a class=" lead-button-default " href="sms:{{$obj->author->phone}}"><img
                                        src="https://static.chotot.com/storage/chotot-icons/png/sms.png"
                                        alt="sms">SMS</a>
                                <a class=" lead-button-default"
                                   href="https://zalo.me/{{$obj->author->phone}}"
                                   target="_blank" rel="nofollow"><img
                                        src="https://static.chotot.com/storage/chotot-icons/png/chat.png"
                                        alt="chat">Chat</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ad-image-caption">
        <span class="ad-image-caption-text">Tin cá nhân đăng {{showHumanTime($obj['created_at'])}}</span>
    </div>
</div>
