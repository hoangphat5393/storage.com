@extends('frontend.layouts.master')

@section('seo')
    @include('frontend.layouts.seo', $seo ?? [])
@endsection

{{-- @section('body-class', 'single') --}}

@php
    use Carbon\Carbon;
    Carbon::setLocale('vi');
    $cdt = new Carbon($news->created_at);
@endphp


@section('content')
    {{-- Menu --}}
    @include('frontend.includes.menu')

    <main id="news_category">

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
                        <div class="col-12 post-detail">
                            <h1 class="d-none">{{ $news->name }}</h1>
                            <h3 class="mb-4">{{ $news->name }}</h3>
                            <div class="follow mb-3">
                                <i class="far fa-calendar-alt"></i> <i>{{ $cdt->format('d-m-Y') }}</i>
                                {{-- <i class="fa fa-eye"></i> <i>Lượt xem: 208</i> --}}
                            </div>
                            <div>
                                {!! htmlspecialchars_decode($news->content) !!}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
@endsection

@push('scripts')
@endpush
