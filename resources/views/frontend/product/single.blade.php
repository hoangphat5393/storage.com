@extends('frontend.layouts.master')
@section('seo')
    @include('frontend.layouts.seo', $seo ?? [])
@endsection

@php
    // dd($gallery);
    use Carbon\Carbon;
    Carbon::setLocale('vi');

    $gallery = '';
    if (isset($product)) {
        extract($product->getAttributes());
        $gallery = isset($gallery) || $gallery != '' ? unserialize($gallery) : '';
    }

    $cdt = new Carbon($product->created_at);
@endphp

@section('content')

    {{-- Menu --}}
    @include('frontend.includes.menu')

    <main id="main" class="site-main">

        <div class="container mt-4">
            <div class="row">
                <div class="col-lg-3 order-2 order-lg-1">
                    {{-- Category --}}
                    <div class="row main-cat mb-3">
                        @include('frontend.includes.left_sidebar')
                    </div>
                </div>

                <div class="col-lg-9 order-1 order-lg-2 mb-5 main-product">

                    <div class="row mb-3">
                        <div class="col-12 product-item product-detail">
                            <h3 class="mb-4">{{ $product->name }}</h3>

                            <div class="row">
                                <div class="col-md-6">
                                    <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper mySwiper2">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <img src="{{ $product->image }}" alt="{{ $product->name }}" />
                                            </div>
                                            @if ($gallery)
                                                @foreach ($gallery as $item)
                                                    <div class="swiper-slide">
                                                        <img src="{{ $item }}" alt="{{ $product->name }}" />
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="swiper-button-next"></div>
                                        <div class="swiper-button-prev"></div>
                                    </div>

                                    <div thumbsSlider="" class="swiper mySwiper">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <img src="{{ get_image($product->image) }}" alt="{{ $product->name }}" />
                                            </div>
                                            @if ($gallery)
                                                @foreach ($gallery as $item)
                                                    <div class="swiper-slide">
                                                        <img src="{{ $item }}" alt="{{ $product->name }}" />
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h1>{{ $product->name }}</h1>
                                    <div class="follow mb-3">
                                        {{-- <i class="far fa-calendar-alt"></i> <i>{{ $cdt->format('d-m-Y') }}</i> --}}
                                        {{-- <i class="fa fa-eye"></i> <i>Lượt xem: 12</i> --}}
                                    </div>
                                    <div class="description">
                                        {!! htmlspecialchars_decode($product->description) !!}
                                    </div>

                                    <p class="price">
                                        @if ($product->price_type == 'price')
                                            <span class="price">
                                                {{ number_format($product->price, 0, ',', '.') }} đ
                                            </span>
                                        @else
                                            <a href="tel:{{ setting_option('phone') }}" class="btn btn-danger btn-lg text-white my-3">
                                                <i class="fa-regular fa-phone"></i> Liên hệ
                                            </a>
                                        @endif
                                    </p>

                                    @if ($product->price_type == 'price')
                                        <form id="product_form_addCart" action="{{ route('cart.addCart') }}">
                                            <input type="hidden" name="product" value="{{ $product->id }}">
                                            <div class="qtyBlock">
                                                <div class="quantity d-flex">
                                                    <input type="button" class="quantity-btn qtyBtn minus" value="-">
                                                    <input type="text" id="quantity_field" class="input-text qty qtyField quantity_field" name="qty" step="1" min="1" value="1" size="8" placeholder="0" pattern="[0-9]*" inputmode="numeric">
                                                    <input type="button" class="quantity-btn qtyBtn plus" value="+">
                                                </div>
                                            </div>

                                            <a href="{{ route('page', 'contact') }}" class="btn btn-danger btn-lg text-white my-3"><i class="fa-regular fa-phone"></i> Giá sỉ - Liên hệ</a>

                                            <button type="button" class="btn btn-success btn-lg product-form__cart-add">
                                                <i class="fa-solid fa-cart-circle-arrow-up"></i> Thêm vào giỏ
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="product-tab_content">Thông tin chi tiết</div>
                                    <div class="product-content">
                                        {!! htmlspecialchars_decode($product->content) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection

@push('scripts')
    <script>
        var cart_ajax_add = "{{ route('cart.addCart') }}";
    </script>

    <script>
        var swiper = new Swiper(".mySwiper", {
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
        });
        var swiper2 = new Swiper(".mySwiper2", {
            spaceBetween: 10,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            thumbs: {
                swiper: swiper,
            },
        });
    </script>


    <script>
        // LOGIN
        $('.login-btn').on('click', function(e) {
            e.preventDefault();
            var username = $('input[name="username"]').val();
            var password = $('input[name="password"]').val();
            // var email = $('#lg_email').val();
            var redirect = $('input[name="url_redirect"]').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                    url: 'ajax/customer/login',
                    type: 'post',
                    data: {
                        username: username,
                        password: password,
                        // email: email
                    },
                })
                .done(function(data) {
                    console.log(data, redirect);
                    $('.error-login-customer').text(data.error_login);
                    $('.error-login-customer').css('display', 'block');
                    if (data.status_login == true) {
                        // location.reload();
                        window.location.replace(redirect);
                    }
                })
                .fail(function() {
                    console.log("error");
                })
                .always(function(data) {
                    console.log(data);
                });
        });
    </script>

    <script>
        // splide.mount();
        document.addEventListener('DOMContentLoaded', function() {

            if ($(".main-slider")[0]) {
                var main = new Splide('.main-slider', {
                    type: 'fade',
                    rewind: true,
                    pagination: false,
                    arrows: false,
                });
                main.mount();
            }

            if ($(".thumbnail-slider")[0]) {
                var thumbnails = new Splide('.thumbnail-slider', {
                    gap: 8,
                    rewind: true,
                    pagination: false,
                    isNavigation: true,
                    arrows: true,
                    perPage: 4,
                    breakpoints: {
                        576: {
                            perPage: 3,
                        },
                    },
                });
                thumbnails.mount();
                main.sync(thumbnails);
            }
        });
    </script>

    {{-- <script>
        $(".gallery-thumb-item").on("click", function(e) {
            $([document.documentElement, document.body]).animate({
                    scrollTop: $("#img-detail-product").offset().top,
                },
                200
            );
        });
    </script> --}}
@endpush
