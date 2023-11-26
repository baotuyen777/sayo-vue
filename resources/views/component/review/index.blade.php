<div class="product-v-desc  col-12 col-xs-12" style="margin-bottom: 20px;">
    <h3>Đánh giá sản phẩm</h3>
    <div class="col-lg-12">
        <div class="thumnail-desc">
            <div class="container">
                <div class="">
                    <div class="thumb-content border-default">
                        <div id="review" class="tab-pane show">
                            <div class="container">
                                <div class="review-body">
                                    <div class="col-2">
                                        <h2 class="h3">{{ $obj->reviews->count() ?? 0 }} {{ __('Đánh giá') }}</h2>
                                        <h3>Đánh giá trung bình</h3>
                                        <span class="d-inline-block align-middle"
                                              style="color: red;font-size: 30px;font-weight: 700">{{ $obj->avg_rate }}/5</span>
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
                                                <div class="text-nowrap me-3"
                                                     style="margin: 0 4px;"><span
                                                        class="d-inline-block align-middle">{{ $star }}</span><i
                                                        class="fa fa-star fs-xs ms-1 text-yellow"></i>
                                                </div>
                                                <div class="w-100" style="width: 80%;">
                                                    <div class="progress"
                                                         style="height: 8px; margin: 0;border-radius: 4px;">
                                                        <div class="progress-bar" role="progressbar"
                                                             style="width: {{ $percent }}%; background-color: {{ $progressbar_color[$star-1] }};"
                                                             aria-valuenow="{{ $percent }}"
                                                             aria-valuemin="0"
                                                             aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <span class="ms-3">{{ $rate_one_count }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <hr style="margin-bottom: 40px;">
                                <div class="form-review" style="margin-bottom: 40px;">
                                    <form action="{{ route('review.store') }}" class="form-ajax" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ data_get($obj, 'id') }}">
                                        <tr style="height: 50px;" class="review-sp">
                                            <td>
                                                <div style="width: 100%; height: 100%">
                                                    <p>Rating: <span class="star-rating">
                                                        <label for="rate-1" style="--i:1"><i class="fa fa-star"></i></label>
                                                        <input type="radio" name="rating" id="rate-1" value="1">
                                                        <label for="rate-2" style="--i:2"><i class="fa fa-star"></i></label>
                                                        <input type="radio" name="rating" id="rate-2" value="2" checked>
                                                        <label for="rate-3" style="--i:3"><i class="fa fa-star"></i></label>
                                                        <input type="radio" name="rating" id="rate-3" value="3">
                                                        <label for="rate-4" style="--i:4"><i class="fa fa-star"></i></label>
                                                        <input type="radio" name="rating" id="rate-4" value="4">
                                                        <label for="rate-5" style="--i:5"><i class="fa fa-star"></i></label>
                                                        <input type="radio" name="rating" id="rate-5" value="5">
                                                    </span></p>
                                                </div>
                                            </td>
                                            <td colspan="3">
                                        <textarea name="content" rows="5" style="width: 100%;"
                                                  placeholder="Đánh giá ..."></textarea>
                                                <label for="review_file"><i class="fa fa-camera" aria-hidden="true"></i></label>
                                                <input type="file" name="files[]" id="review_file">
                                                <button type="submit" class="btn btn-yellow">Đánh giá</button>
                                            </td>
                                        </tr>
                                    </form>
                                    @if ($errors->any())
                                        <p style="color: red;">{{ $errors->first() }}</p>
                                    @endif
                                </div>
                                <hr>
                                <div class="col-6 col-lg-6 row pb-3">
                                    <div class="col-md-12 col-lg-12" style="margin-left: 20px;">
                                        <?php $reviews = $obj->reviews ?? []; ?>
                                        @if (!empty($reviews))
                                            @foreach ($reviews as $rating)
                                                <div class="product-review pb-4 mb-4 border-bottom">
                                                    <div
                                                        style="width: 100%;display: flex;justify-items: center;justify-content: space-between">
                                                        <div
                                                            style="display: flex;justify-items: center">
                                                            <img
{{--                                                                @if(!empty(optional($rating->user)->avatar))--}}
{{--                                                                    src="{{ asset('assets/upload').'/'. optional($rating->user)->avatar }}"--}}
{{--                                                                @else--}}
                                                                    src="{{asset('img/icon/default_user.png')}}"
{{--                                                                @endif--}}
                                                                class="img-circle img-sm"
                                                                alt="Profile Picture">
                                                            <div style="margin-left: 4px;">
                                                                <h6 class="fs-sm mb-0">{{ $rating->user->username }}</h6>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="star-rating text-yellow">
                                                                {!! rating_star($rating->rating) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="fs-md mb-2"
                                                       style="margin-top: 10px;">{{ $rating->content }}</p>
                                                    @php $files = json_decode($rating->images) ?? []; @endphp
                                                    <div class="review-img">
                                                        @foreach($files as $file)
                                                            <img src="{{asset('storage/'.$file)}}" alt="">
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                        <div class="text-center">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


