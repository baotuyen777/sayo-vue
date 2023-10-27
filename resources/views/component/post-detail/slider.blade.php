<div class="post-slider">
    <div class="slick-slider slick-initialized" dir="ltr">
        <div class="slick-track">
            <div data-index="0" class="slick-slide item">
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
            @foreach($obj['files'] as $i => $img)
                <div data-index="{{$i+1}}" class="slick-slide item">
                    <div class="ad-slider-image">
                        <div class="ad-image-slider">
                            <div class="ad-image-wrapper-slider">
                                <img alt="{{$obj['name']}}" src="{{$img['url']}}">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <button class="ad-image-button ad-image-prev control_prev" aria-label="Prev" tabindex="0"
                type="button"><i></i></button>
        <button class="ad-image-button ad-image-next control_next" aria-label="Next" tabindex="0"
                type="button"><i></i></button>
        <ul class="slick-dots">
            @foreach($obj['files'] as $i => $img)
                <li class="{{$i==0 ? 'slick-active' : ''}}" >
                    <button>{{$i}}</button>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="ad-image-caption">
        <span class="ad-image-caption-text">Tin cá nhân đăng {{showHumanTime($obj['created_at'])}}</span>
    </div>
</div>
