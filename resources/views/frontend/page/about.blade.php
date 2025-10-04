@extends('frontend.layouts.master')

@section('seo')
    @include('frontend.layouts.seo', $seo ?? [])
@endsection

@php
    // $custom_fields = $page->custom_field ? json_decode($page->custom_field, true) : '';
@endphp

@section('content')
    <main id="about">

        {{-- Menu --}}
        @include('frontend.includes.menu')


        <section id="block12">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        {{-- Page content --}}
                        {!! htmlspecialchars_decode($page->content) !!}
                        {{-- Page content End --}}
                    </div>
                </div>
            </div>
        </section>

        {{-- Subscribe --}}
        @include('frontend.includes.subscribe')

    </main>
@endsection


@push('scripts')
    {{-- <script>
        var main_splide = new Splide('.main-splide', {
            arrows: false,
            gap: '1.25rem',
            pagination: true,
            arrows: false
        });
        main_splide.mount();
    </script> --}}
@endpush
