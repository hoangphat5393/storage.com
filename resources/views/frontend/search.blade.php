@extends('frontend.layouts.master')

@section('seo')
    <title>Search</title>
@endsection

@php
    use Carbon\Carbon;
    Carbon::setLocale('vi');
@endphp

@section('content')
    <main id="news_category">

        {{-- Menu --}}
        @include('frontend.includes.menu')

        {{-- Hero Section --}}
        {{-- @include('theme.includes.hero_section') --}}

        {{-- Hot Product --}}
        {{-- @include('theme.includes.hot_slider') --}}

        <section class="block8 py-4">
            <div class="container">

                <div class="row">
                    <div class="col-lg-3 order-2 order-lg-1">
                        {{-- Category --}}
                        <div class="row main-cat mb-3">
                            @include('frontend.includes.left_sidebar')
                        </div>
                    </div>

                    <div class="col-lg-9 order-1 order-lg-2 mb-5 main-product">
                        <div class="row">
                            <div class="col-lg-12">
                                <h1 class="category-title">@lang('Search')</h1>
                                <p class="fs-4">Từ tìm kiếm: <strong>{{ $keyword ?? '' }}</strong></p>
                            </div>
                        </div>

                        @if ($product->count() > 0)
                            <div class="row my-3">
                                {{-- Product item --}}
                                @foreach ($product as $item)
                                    <div class="col-6 col-md-3">
                                        <div class="product-item mb-3">
                                            <figure class="text-center">
                                                <a href="{{ route('product.detail', [$item->slug, $item->id]) }}" title="{{ $item->name }}">
                                                    <img class="w-100" src="{{ get_image($item->image) }}" alt="{{ $item->name }}">
                                                </a>
                                                <figcaption><a href="{{ route('product.detail', [$item->slug, $item->id]) }}">{{ $item->name }}</a></figcaption>
                                                @if ($item->price)
                                                    Giá:
                                                    <span class="price">
                                                        {{ number_format($item->price, 0, ',', '.') }} đ
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
                            <div class="nav-pagination">
                                {!! $product->appends(request()->input())->links('frontend.pagination.custom') !!}
                            </div>
                        @else
                            <p>Không có sản phẩm nào</p>
                        @endif
                    </div>
                </div>

            </div>
        </section>

        {{-- Subscribe --}}
        @include('frontend.includes.subscribe')
    </main>
@endsection
