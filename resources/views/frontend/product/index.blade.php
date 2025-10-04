@extends('frontend.layouts.master')
@section('seo')
    @include('frontend.layouts.seo', $seo ?? [])
@endsection

@section('body-class', 'archive post-type-archive post-type-archive-product wp-custom-logo theme-amaya woocommerce-shop woocommerce woocommerce-page woocommerce-js shop nomobile product-title-use-headline-font content-light')

@section('content')
    <main id="main">

        {{-- Menu --}}
        @include('frontend.includes.menu')

        <div class="container mt-4">
            <div class="row">
                <div class="col-lg-3 order-2 order-lg-1">
                    {{-- Category --}}
                    <div class="row main-cat mb-3">
                        @include('frontend.includes.left_sidebar')
                    </div>
                </div>
                @php
                    $category = \App\Models\Frontend\Category::where('type', 'product')->get();
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
                                                                <img class="w-100" src="{{ $item2->image }}" alt="{{ $item2->name }}">
                                                            </a>
                                                            <figcaption>
                                                                <a href="{{ route('product.detail', [$item2->slug, $item2->id]) }}">{{ $item2->name }}</a>
                                                            </figcaption>
                                                        </figure>
                                                        <p class="text-center">
                                                            Giá:
                                                            @if ($item2->price_type == 'price')
                                                                <span class="price">
                                                                    {{ number_format($item2->price, 0, ',', '.') }} đ
                                                                </span>
                                                            @else
                                                                <span class="price">
                                                                    <a href="tel:{{ setting_option('phone') }}">Liên hệ</a>
                                                                </span>
                                                            @endif
                                                        </p>
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

    </main>
@endsection


@push('scripts')
@endpush
