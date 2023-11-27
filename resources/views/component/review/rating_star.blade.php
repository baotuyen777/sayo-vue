@foreach(range(1, 5) as $rate)
    @if($rating >= $rate)
        <i class="fa fa-star"></i>
    @elseif($rating == $rate - 0.5)
        <i class="fa fa-star-half-o" aria-hidden="true"></i>
    @else
        <i class="fa fa-star-o" aria-hidden="true"></i>
    @endif
@endforeach


