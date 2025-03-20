<section class="container filter-block">
    <form action="{{url()->current()}}">
        <div class="flex-row">
            @php
            @endphp
            @include('component.form.filter.selectCategory', ['options' => $categories])
            @include('component.form.filter.selectProvince', ['options' => $provinces])
            @if($province)
                @include('component.form.filter.selectDistrict', ['options' => $districts])
            @endif
            @if($district)
                @include('component.form.filter.selectWard', ['options' => $wards])
            @endif

            @include('component.form.filter.rangePrice')
            @include('component.form.filter.keyword')
        </div>

    </form>
</section>
