@if(isLoged())
    @php
        $isUpdate = !!data_get($obj, 'id');
        $id= data_get($obj, 'id');
    @endphp
    <div class="form-review separate">
        <form
            action="{{$isUpdate ? route('review.update',['review'=> $id]) : route('review.store') }}"
            class="form-ajax" method="POST" data-id="{{$id}}"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="product_id " value="{{ $productId ?? data_get($obj, 'product_id') }}" >
            <tr class="review-sp">
                <td>
                    <p>Rating:
                        <span class="star-rating">
                            @foreach(range(1, 5) as $star)
                                <label for="rate-{{ $star }}-{{data_get($obj, 'id')}}" style="--i:{{ $star }}"><i
                                        class="fa fa-star"></i>
                                </label>
                                <input type="radio" name="rating" id="rate-{{ $star }}-{{data_get($obj, 'id')}}"
                                       value="{{ $star }}" {{ ($star === 5) ? 'checked' : '' }}>
                            @endforeach</span>
                    </p>
                </td>
                <td colspan="3">
                    <textarea name="content" rows="5" placeholder="Đánh giá ...">{{$obj->content ?? null}}</textarea>
                    <div id="upload_images">
                        @include('component.form.uploadFiles', ['obj' => $obj])
                    </div>
                    <button type="submit" class="btn btn-yellow">{{$isUpdate ?'Cập nhật' :'Đánh giá'}}</button>
                </td>
            </tr>
        </form>
    </div>
@else
    <p>Bạn cần <a href="{{route('login')}}"><b>Đăng nhập</b></a> để đánh giá </p>
@endif
