@extends('layout/index')

@section('content')
    <main>
        <div class="container">
            <div class="boxContentLeft col-md-9">
                <div class="white-box row">

                    <div class="col-md-12">
                        <div class="row">
                            <h1 class="_2zdqGOJc4f6iUkBg6thtv1 page-title" id="pageTitle">
                                <p class="tw-mb-1">Quản lý tin đăng</p>
                                <div class="_2zdqGOJc4f6iUkBg6thtv1 _2qzumClAWY5VnmGbExqzLS">
                                    <a
                                        href="#"
                                        class="nYBRGIw98Ez3fjTDA2-TW tw-mr-1" target="_blank">Đơn bán</a></div>
                            </h1>
                        </div>

                        <div class="tw-relative">
                            <div class="_1Xxc1lotHxJaz_2EttIbaU tw-hidden md:tw-block">
                                <div class="_3koXJCkMo96Va7IafPEleg tw-float-left"><a
                                        href="https://www.chotot.com/user/4f2ec5c602bfeafed9d899dcc62c6ba2"><img
                                            src="https://cdn.chotot.com/uac2/1047384"></a></div>
                                <div class="_25H1ekVUjqjsYJSnHq6sTf tw-float-left">
                                    <div class="_2tNHMsiWHVl7nRZTUAw9D8"><a
                                            href="https://www.chotot.com/user/4f2ec5c602bfeafed9d899dcc62c6ba2"><span>Bùi Văn Tuyên</span></a>
                                    </div>
                                    <div class="tw-clear-both"></div>
                                    <span class="tw-mr-1"><a
                                            href="https://www.chotot.com/user/4f2ec5c602bfeafed9d899dcc62c6ba2"
                                            class="_3CtrUNhTq2g1jKGiFu7qVo">Trang cá nhân</a></span><span
                                        class="tw-mr-1"><a
                                            href="https://www.chotot.com/escrow/my-orders/identity/seller"
                                            class="_3CtrUNhTq2g1jKGiFu7qVo">Đơn bán</a></span>
                                    <div></div>
                                </div>
                                <div class="tw-clear-both"></div>
                            </div>
                            <div>
                                <div class="_1kwPmWyVexdoZbW6IOSkmM"><img
                                        src="https://static.chotot.com/storage/icons/svg/whats_new_mobile.svg"><img
                                        class="_2XPw19fDldgdilK2ChJUGy"
                                        src="https://static.chotot.com/storage/icons/svg/close.svg"></div>
                            </div>
                        </div>
                        <div>
                            <div class="row relativeBox">
                                <div></div>
                                <div></div>
                            </div>
                            <div></div>
                        </div>
                    </div>
                </div>
                <div class="row noMargin _3ItG4vnT-FSnJk1UzUnzQ-" id="headingRow">
                    <div>
                        <div>
                            <div class="redux-infinite-scroll " style="height: 100%;">
{{--                                @for($i=0;$i<20;$i++)--}}
                                    @include('component.post.post-horizontal')
{{--                                @endfor--}}

                                <div></div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="_3gQN1j7PQSNOr1NLokmZpF hiddenLoadMore" id="loadMoreButton"><span>•••</span>
                            </div>
                        </div>
                        <div></div>
                    </div>
                    <div></div>
                </div>
                <span id="scroll_top" style="display: none;"><i class="fa fa-angle-up" aria-hidden="true"></i></span>
            </div>
        </div>
    </main>

@endsection
