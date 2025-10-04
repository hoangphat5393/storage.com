@extends('frontend.layouts.master')

@section('seo')
    @include('frontend.layouts.seo', $seo ?? [])
@endsection

@php
    use Carbon\Carbon;
    Carbon::setLocale('vi');
@endphp

@section('content')
    <main id="main">

        {{-- Menu --}}
        @include('frontend.includes.menu')

        {{-- Hero Section --}}
        {{-- @include('frontend.includes.hero_section') --}}

        {{-- Hot Product --}}
        {{-- @include('frontend.includes.hot_slider') --}}

        <div class="container mt-4">
            <div class="row">
                <div class="col-lg-3 order-2 order-lg-1">
                    {{-- Category --}}
                    <div class="row main-cat mb-3">
                        @include('frontend.includes.left_sidebar')
                    </div>
                </div>

                @php
                    $category = \App\Models\Frontend\Category::where(['type' => 'product', 'status' => 1, 'hot' => 1])
                        ->orderbyDesc('sort')
                        ->get();
                @endphp

                @empty(!$category)
                    <div class="col-lg-9 order-1 order-lg-2 mb-5 main-product">
                        @foreach ($category as $item)
                            <div class="row mb-3">
                                <div class="col-12">
                                    <h3>{{ $item->name }}</h3>

                                    @empty(!$item->products)
                                        <div class="row mt-4">
                                            {{-- Product item --}}
                                            @foreach ($item->products as $item2)
                                                <div class="col-6 col-md-3">
                                                    <div class="product-item">
                                                        <figure class="text-center">
                                                            <a href="{{ route('product.detail', [$item2->slug, $item2->id]) }}" title="{{ $item2->name }}">
                                                                <img class="w-100" src="{{ get_image($item2->image) }}" alt="{{ $item2->name }}">
                                                            </a>
                                                            <figcaption>
                                                                <a href="{{ route('product.detail', [$item2->slug, $item2->id]) }}">{{ $item2->name }}</a>
                                                            </figcaption>
                                                            @if ($item2->price)
                                                                <span class="price">
                                                                    {{ number_format($item2->price, 0, ',', '.') }} đ
                                                                </span>
                                                            @else
                                                                <span class="price">
                                                                    <a href="tel:{{ setting_option('phone') }}">Liên hệ</a>
                                                                </span>
                                                            @endif
                                                        </figure>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endempty
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endempty
            </div>
        </div>

        {{-- Subscribe --}}
        @include('frontend.includes.subscribe')

        <div class="container my-5">
            <div class="row main_news justify-content-center">

                <div class="col-lg-4">
                    <h4>VIDEO CLIP</h4>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="ajax_video" class="ajax_video p-2">
                                <iframe width="100%" height="290" src="https://www.youtube.com/embed/blgRF0H8gVk" frameborder="0" allowfullscreen=""></iframe>
                                <select name="list-video" class="form-control list-video">
                                    <option value="blgRF0H8gVk">Cách trồng rau cải hữu cơ: xà lách, bẹ xanh và bẹ ngọt tại nhà.</option>
                                    <option value="qr6bTDJefMs">Cách trồng và chăm sóc hoa đồng tiền cho hoa đẹp 4 mùa</option>
                                    <option value="eBDh72nyDvs">Trồng và chăm sóc cúc đồng tiền sau khi chơi tết</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tin tức nông nghiệp (News) --}}
                @php
                    $news = \App\Models\Frontend\Post::where('status', 1)->orderByDesc('sort')->limit(3)->get();
                @endphp
                <div class="col-lg-4">
                    <h4>Tin tức nông nghiệp</h4>
                    @empty(!$news)
                        <div class="post-slider p-2">
                            <div class="swiper hotNews">
                                <div class="swiper-wrapper">
                                    @foreach ($news as $item)
                                        @php $cdt = new Carbon($item->created_at); @endphp
                                        <div class="swiper-slide">
                                            <div class="item-product">
                                                <a href="{{ route('news.detail', [$item->slug, $item->id]) }}" title="{{ $item->name }}">
                                                    <div class="product-img">
                                                        <img src="{{ get_image($item->image) }}" class="border border-5 border-white rounded-2" alt="{{ $item->name }}">
                                                    </div>
                                                </a>
                                                <div class="bgdate float-left text-center">
                                                    <strong>{{ $cdt->format('d') }}</strong>
                                                    <br>
                                                    THÁNG {{ $cdt->format('m') }}
                                                </div>
                                                <h5 class="hotNews__title">
                                                    <a href="{{ route('news.detail', [$item->slug, $item->id]) }}">{{ $item->name }}</a>
                                                </h5>
                                                <div class="hotNews__description">
                                                    {!! htmlspecialchars_decode($item->description) !!}
                                                </div>
                                            </div>

                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endempty
                </div>
            </div>
        </div>

        {{-- Partner --}}
        {{-- @include('theme.includes.partner') --}}

    </main>
@endsection

@push('scripts')
    <script>
        if ($(".hotNews")[0]) {
            const hotNews = new Swiper(".hotNews", {
                slidesPerView: 1,
                spaceBetween: 30,
                grabCursor: true,
                a11y: false,
                freeMode: true,
                loop: true,
                speed: 1000,
                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false,
                },

                // breakpoints: {
                //     768: {
                //         slidesPerView: 3,
                //     },
                //     992: {
                //         slidesPerView: 4,
                //     },
                //     1200: {
                //         slidesPerView: 6,
                //     },
                // },
                // pagination: {
                //     el: ".swiper-pagination",
                //     clickable: true,
                // },
            });
        }

        $().ready(function(e) {
            $('.list-video').change(function() {
                var url = 'https://www.youtube.com/embed/' + $(this).val();
                $('#ajax_video iframe').attr('src', url);
            })
        });
    </script>
@endpush
