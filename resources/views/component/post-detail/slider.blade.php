<div class="post-slider">
    <div class="slick-slider slick-initialized" dir="ltr">
        <div class="slick-track">
            <div data-index="0" class="slick-slide item">
                <div class="AdImage_sliderImage__ddiFA">
                    <div class="AdImage_sliderWrapper___jIpt">

                    </div>
                    <div class="LeadButtonSlide_wrapperLeadButton__gyTxQ">
                        <a class=" LeadButtonSlide_buttonDefault__iE9j1 " href="tel:123-456-7890"> <img
                                src="https://static.chotot.com/storage/chotot-icons/png/call-green.png"
                                alt="call">Gọi điện</a>
                        <a class=" LeadButtonSlide_buttonDefault__iE9j1 " href="sms:+911234567890"><img
                                src="https://static.chotot.com/storage/chotot-icons/png/sms.png"
                                alt="sms">SMS</a>
                        <a class=" LeadButtonSlide_buttonDefault__iE9j1"
                           href="https://chat.chotot.com/chatroom/join/MjU2ODExMjl8MTA5MDg2Njg4"
                           target="_blank" rel="nofollow"><img
                                src="https://static.chotot.com/storage/chotot-icons/png/chat.png"
                                alt="chat">Chat</a>
                    </div>
                </div>
            </div>
            @foreach($obj['files'] as $i => $img)
                <div data-index="{{$i+1}}" class="slick-slide item">
                    <div class="AdImage_sliderImage__ddiFA">
                        <div class="AdImage_sliderWrapper___jIpt">
                            <div class="AdImage_imageWrapper__j1z2m">
                                <img alt="{{$obj['name']}}" src="{{asset('storage/'.$img['url'])}}">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <button class="AdImage_button__ho9Jx AdImage_Prev__ciQdk control_prev" aria-label="Prev" tabindex="0"
                type="button"><i></i></button>
        <button class="AdImage_button__ho9Jx AdImage_Next__TX7EW control_next" aria-label="Next" tabindex="0"
                type="button"><i></i></button>
        <ul class="slick-dots" style="display: block;">
            <li class="slick-active">
                <button>1</button>
            </li>
            <li>
                <button>2</button>
            </li>
        </ul>
    </div>
    <div class="AdImage_imageCaption__aUFNp">
        <span class="AdImage_imageCaptionText__ScM56">Tin cá nhân đăng {{showHumanTime($obj['created_at'])}}</span>
    </div>
</div>
