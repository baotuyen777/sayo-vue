@if(isLoged())
    <div class="form-review separate">
        <form action="{{ route('review.store') }}" class="form-ajax" method="POST"
              enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="product_id" value="{{ data_get($obj, 'id') }}">
            <tr class="review-sp">
                <td>
                    <p>Rating:
                        <span class="star-rating">
                                        @foreach(range(1, 5) as $star)
                                <label for="rate-{{ $star }}" style="--i:{{ $star }}"><i class="fa fa-star"></i></label>
                                <input type="radio" name="rating" id="rate-{{ $star }}" value="{{ $star }}" {{ ($star === 5) ? 'checked' : '' }}>
                            @endforeach
                                    </span>
                    </p>
                </td>
                <td colspan="3">
                    <textarea name="content" rows="5" placeholder="Đánh giá ..."></textarea>
                    <div id="upload_images">
                        @include('component.form.uploadFiles', ['obj' => null])
                    </div>
                    <button type="submit" class="btn btn-yellow">Đánh giá</button>
                </td>
            </tr>
        </form>
    </div>
@else
    <p>Bạn cần <a href="{{route('login')}}"><b>Đăng nhập</b></a> để đánh giá </p>
@endif
