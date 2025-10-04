@extends('frontend.layouts.master')

@section('seo')
    @include('frontend.layouts.seo', $seo ?? [])
@endsection

@section('body-class', 'blog')

@php
    use Carbon\Carbon;
    Carbon::setLocale('vi');
@endphp

@section('content')

    {{-- Menu --}}
    @include('frontend.includes.menu')

    <main id="main" class="main-product">
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
                        <div class="col-12">
                            <h3>Tin tức nông nghiệp</h3>

                            <div class="row post-item mt-4">
                                @foreach ($news as $item)
                                    @php $cdt = new Carbon($item->created_at);@endphp
                                    <div class="col-6 mb-3">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <a href="{{ route('news.detail', [$item->slug, $item->id]) }}" title="{{ $item->title }}">
                                                    <img src="{{ $item->image }}" alt="{{ $item->title }}">
                                                </a>
                                            </div>
                                            <div class="col-md-8">
                                                <h4>
                                                    <a href="{{ route('news.detail', [$item->slug, $item->id]) }}" title="{{ $item->title }}">
                                                        {{ $item->title }}
                                                    </a>
                                                </h4>
                                                <i class="far fa-calendar-alt"></i> <i>{{ $cdt->format('d-m-Y') }}</i>
                                            </div>
                                        </div>
                                        <div class="mt-2 line-clamp-3">
                                            {!! htmlspecialchars_decode($item->description) !!}
                                        </div>
                                    </div>
                                @endforeach


                            </div>
                        </div>

                    </div>

                    <div class="nav-pagination">
                        {{ $news->links('frontend.pagination.custom') }}
                        {{-- {{ $news->links() }} --}}
                    </div>

                </div>

            </div>
        </div>

    </main>

@endsection
