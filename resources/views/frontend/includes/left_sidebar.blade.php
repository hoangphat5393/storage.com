@php
    $category = \App\Models\Frontend\Category::where(['type' => 'product', 'parent' => 0, 'status' => 1])->get();
    // dd($category);
@endphp

<div class="col-sm-12 col-md-6 col-md-12 mb-4 d-none d-lg-block">
    <div class="bg-title">
        <h2>DANH MỤC SẢN PHẨM</h2>
    </div>
    <div class="main-cat-content">
        @empty(!$category)
            <ul class="list-group list-group-flush">
                @foreach ($category as $item)
                    <li class="list-group-item">
                        <a class="" href="{{ route('product.category', $item->slug) }}" title="{{ $item->name }}">{{ $item->name }}</a>
                        @if ($item->children()->exists())
                            <ul class="list-group list-group-flush ml-3">
                                @foreach ($item->children as $item2)
                                    <li class="list-group-item">
                                        <a class="" href="{{ route('product.category', $item2->slug) }}" title="{{ $item2->name }}">{{ $item2->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                    </li>
                @endforeach
            </ul>
        @endempty
    </div>
</div>

{{-- Support --}}
<div class="col-sm-12 col-md-6 col-md-12 d-none">
    <div class="bg-title">
        <h2>HỖ TRỢ TRỰC TUYẾN</h2>
    </div>

    <div class="main-cat-content main-support">
        <img class="w-100" src="{{ asset('images/bg-hotro.jpg') }}" alt="">
        <div class="d-flex phone p-1">
            <img class="img-fluid mr-2" src="{{ asset('images/icon-phone.png') }}" alt="">
            <p>HOTLINE:<br><span>{{ setting_option('phone') }}</span></p>
        </div>
        <div class="box-support mt-1">
            <strong>Liên Hệ Đặt Hàng: </strong>
            <a href="https://zalo.me/{{ setting_option('zalo') }}" target="_blank">
                <img src="{{ asset('images/icon-zalo.png') }}" alt="icon-zalo">
            </a>
            <p class="text-break">
                Hotline: <a href="tel:{{ setting_option('phone') }}" class="phone-number">{{ setting_option('phone') }}</a>
                <br>
                <a href="mailto:{{ setting_option('email') }}">{{ setting_option('email') }}</a>
            </p>
        </div>
    </div>
</div>
