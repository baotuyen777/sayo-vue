@php


       // Get the current route
       $currentRoute = \Route::currentRouteName();

       // Define your breadcrumb mapping
       $breadcrumbs = [
           'home' => 'Trang chủ',
           'products.index' => 'Products',
           'products.show' => 'Product Details',
       ];



@endphp
<div class="container">
    <ol class="breadcrumb">
        <li><a href="{{env('APP_URL')}}">Trang chủ</a></li>
        <li>
            <a href="https://www.chotot.com/mua-ban-ban-ghe"><span
                >Bàn ghế</span></a></li>
        <li>
            <a href="https://www.chotot.com/mua-ban-ban-ghe-ha-noi"><span
                >Bàn ghế Hà Nội</span></a></li>
        <li>
            <a href="https://www.chotot.com/mua-ban-ban-ghe-quan-nam-tu-liem-ha-noi"><span
                >Bàn ghế Quận Nam Từ Liêm</span></a>
        </li>
        <li class="BreadCrumb_breadcrumbItem__M8Q4i" itemprop="itemListElement">
            <span>ghế xoay mới 95%</span>
        </li>
    </ol>

</div>
