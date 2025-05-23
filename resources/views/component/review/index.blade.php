<div class="product-reviews">
    <h3>Đánh giá sản phẩm</h3>
    <div class="container">
        <div id="review" class="tab-pane show">
            <div class="container">
                <div class="review-body">
                    <div class="col-2">
                        <h2 class="h3">{{ $obj->reviews->count() ?? 0 }} {{ __('Đánh giá') }}</h2>
                        <h3>Đánh giá trung bình</h3>
                        <span class="avg-rate">{{ $obj->avg_rate }}/5</span>
                        <div class="star-rating text-yellow me-2">
                            @foreach (range(1, 5) as $rate)
                                @if ($obj->avg_rate >= $rate)
                                    <i class="fa fa-star"></i>
                                @elseif ($obj->avg_rate == $rate - 0.5)
                                    <i class="fa fa-star-half-o"
                                       aria-hidden="true"></i>
                                @else
                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="col-2">
                        @php
                            $rate_count = $obj->reviews->count();
                            $progressbar_color = ['#f34770', '#fea569', '#ffda75', '#a7e453', '#42d697'];
                        @endphp
                        @foreach (range(5, 1) as $star)
                            @php
                                $rate_one_count = $obj->reviews->where('rating', $star)->count();
                                $percent = 0;
                                if ($obj->reviews->count() > 0)
                                    $percent = $rate_one_count / $rate_count * 100;
                            @endphp
                            <div class="review__progress">
                                <div class="text-nowrap me-3"><span
                                        class="d-inline-block align-middle">{{ $star }}</span><i
                                        class="fa fa-star fs-xs ms-1 text-yellow"></i>
                                </div>
                                <div class="w-80">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar"
                                             style="width: {{ $percent }}%; background-color: {{ $progressbar_color[$star-1] }};"
                                             aria-valuenow="{{ $percent }}"
                                             aria-valuemin="0"
                                             aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <span class="number">{{ $rate_one_count }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                <hr class="separate">

                @include('component.review.form',['obj'=>null,'productId'=> $obj->id])
                <hr>
                <div class="col-md-12 col-lg-12">
                    <?php
                    $reviews = $obj->reviews ?? []; ?>
                    @if (!empty($reviews))
                        @foreach ($reviews as $review)
                            <div class="product-review pb-4 mb-4 border-bottom">
                                <div class="info">
                                    <div class="customer-info">
                                        <img src="{{asset('img/icon/default_user.png')}}"
                                             class="img-circle img-sm" alt="Profile Picture">
                                        <div class="view">
                                            <h4 class="username">{{ $review->user->username }}</h4>
                                            <div class="star-rating text-yellow">
                                                @include('component.review.rating_star', ['rating' => $review->rating])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p class="product-review__content">{{ $review->content }}</p>
                                @php
                                    $files = $review->files ?? [];
                                @endphp
                                <div class="review-img btn-modal" data-modal-id="modal-view-image-{{$review->id}}">
                                    @foreach($files as $file)
                                        <img src="{{asset('storage/'.$file['url'])}}" alt="">
                                    @endforeach
                                </div>
                                <div class="setting-dropdown">
                                    <button class="btn-3dot"></button>
                                    <ul class="dropdown">
                                        @if(Auth::id()=== $review->author_id)
                                            <li><span href="#" class="btn-modal"
                                                      data-modal-id="modal-edit-review-{{$review->id}}">Sửa</span></li>
                                            <li><span href="#">Xóa</span></li>
                                        @endif
                                        <li><span href="#">Báo cáo vi phạm</span></li>
                                    </ul>
                                </div>

                            </div>

                            <div id="modal-view-image-{{$review->id}}" class="modal">
                                <i class="fa fa-times close" aria-hidden="true"></i>
                                <h1 class="title">Ảnh đánh giá</h1>
                                @include('component.post-detail.slider',['obj'=>$review])
                            </div>
                            <div id="modal-edit-review-{{$review->id}}" class="modal">
                                <i class="fa fa-times close" aria-hidden="true"></i>
                                <h1 class="title">Sửa đánh giá</h1>
                                @include('component.review.form', ['obj'=>$review])
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
