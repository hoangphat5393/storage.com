@extends('backend.layouts.master')

@php
    $lc = app()->getLocale();

    if (isset($product)) {
        $product_info = $product->getInfo;
        if ($product_info != '') {
            extract($product_info->toArray());
        }
        extract($product->getAttributes());
        $gallery = isset($gallery) || $gallery != '' ? json_decode($gallery) : '';
    }

    $title_head = $name ?? __('Add product');
    $id = $id ?? 0;
    $spec_short = $spec_short ?? '';
    $price_type = $price_type ?? 'price';

    if (request()->route()->named('admin.product.create')) {
        $form_action = route('admin.product.store'); // Create news
    } else {
        $form_action = route('admin.product.update', $id); // Update news
    }
@endphp

@section('seo')
    @php
        $seo = [
            'title' => $title_head . ' | ' . Helpers::get_option_minhnn('seo-title-add'),
            'keywords' => Helpers::get_option_minhnn('seo-keywords-add'),
            'description' => Helpers::get_option_minhnn('seo-description-add'),
            'og_title' => $title_head . ' | ' . Helpers::get_option_minhnn('seo-title-add'),
            'og_description' => Helpers::get_option_minhnn('seo-description-add'),
            'og_url' => Request::url(),
            'og_img' => asset('images/logo_seo.png'),
            'current_url' => Request::url(),
            'current_url_amp' => '',
        ];
    @endphp
    @include('backend.partials.seo')
@endsection

@section('content')
    {{-- begin::App Content Header --}}
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">{{ $title_head }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $title_head }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    {{-- end::App Content Header --}}

    {{-- begin::App Content --}}
    <div class="app-content">
        <div class="container-fluid">

            <form id="formEdit" action="{{ $form_action }}" method="POST" enctype="multipart/form-data">
                @if (!request()->route()->named('admin.product.create'))
                    @method('PUT')
                @endif
                @csrf

                <input type="hidden" name="id" value="{{ $id ?? 0 }}">

                <div class="row">
                    <div class="col-9">

                        {{-- card --}}
                        <div class="card card-primary card-outline mb-4">

                            {{-- header --}}
                            <div class="card-header">
                                <h3 class="card-title">{{ $title_head }}</h3>
                            </div>


                            <div class="card-body">

                                {{-- show error form --}}
                                <div class="errorTxt"></div>

                                <div class="mb-3">
                                    <label for="slug" class="form-label">Slug</label>
                                    <input type="text" class="form-control" id="slug" name="slug" placeholder="Slug" value="{{ $slug ?? '' }}">
                                    @if ($id > 0)
                                        <p class="my-2">
                                            <strong class="text-primary">Link Vi:</strong>
                                            <u><i><a href="{{ route('product.detail', [$slug, $id]) }}" target="_blank" class="text-red">{{ route('product.detail', [$slug, $id]) }}</a></i></u>
                                        </p>
                                        {{-- <p>
                                            <strong class="text-primary">Link EN:</strong>
                                            <u><i><a href="{{ route('news.detail', [$slug, $id], true, 'en') }}" target="_blank" class="text-red">{{ route('news.detail', [$slug, $id], true, 'en') }}</a></i></u>
                                        </p> --}}
                                    @endif
                                </div>

                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="vi" role="tabpanel" aria-labelledby="vi-tab">

                                        @include('backend.product.data_field', ['lc' => 'vi'])

                                    </div>
                                </div>

                            </div>
                        </div>
                        {{-- end::card --}}

                        {{-- Gallery --}}
                        @include('backend.partials.galleries', ['gallery_images' => $gallery ?? ''])
                        {{-- End::Gallery --}}

                        {{-- price_stock --}}
                        @include('backend.product.price_stock', ['price_type' => $price_type])
                        {{-- End::price_stock  --}}

                    </div>

                    <div class="col-md-3">

                        @include('backend.partials.action_button')

                        {{-- SELECT CATEGORY --}}
                        <div class="card widget-category mb-3">

                            {{-- header --}}
                            <div class="card-header">
                                <h3 class="card-title">@lang('admin.categories')</h3>
                            </div>

                            <div class="card-body max-vh-75">
                                <div class="inside clear">
                                    @php
                                        $array_checked = isset($product_detail) ? $product_detail->categories->pluck('id')->toArray() : [];
                                        $category_type = 'product';
                                    @endphp
                                    @include('backend.partials.category-item')
                                </div>
                            </div>
                        </div>
                        {{-- END SELECT CATEGORY --}}

                        {{-- UPLOAD IMAGE --}}
                        @include('backend.partials.image', ['title' => 'Ảnh đại diện', 'id' => 'img', 'name' => 'image', 'image' => $image ?? ''])
                        {{-- @include('backend.partials.image', ['title' => 'Ảnh đại diện', 'id' => 'cover-img', 'name' => 'cover', 'image' => $cover ?? '']) --}}
                        {{-- END UPLOAD IMAGE --}}
                    </div>
                </div>
                {{-- end::row --}}

                {{-- SEO --}}
                <div class="row">
                    <div class="col-12 col-md-9">
                        @include('backend.partials.form-seo')
                    </div>
                </div>
                {{-- END SEO --}}
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        editor('content');
        // editorQuote('description');

        // auto check parrent
        $('#muti_menu_post input').each(function(index, el) {
            if ($(this).is(':checked')) {
                $(this).closest('.sub-menu').parent().find('label').first().find('input').prop('checked', true);
            }
        });

        // $('#display_price').on('focusin, focusout', function() {
        //     val = $(this).val();
        //     $('#price').val(val);
        //     total_price();
        // });

        // const total_price = () => {
        //     var price = parseFloat($('#price').val());
        //     var stock = parseFloat($('#stock').val());

        //     decimals = 2;
        //     if (price.toString().split(".").length > 1)
        //         var decimals = price.toString().split(".")[1].length;

        //     // var total_price = (parseFloat(price) * stock).toFixed(coutfixed);

        //     var total_price = number_format(price * stock, decimals, '.', ',');

        //     // console.log(arr.length);
        //     $('#total_price').val(total_price);
        // };

        // $('#price, #stock').on('change', () => {
        //     total_price();
        // });
        // total_price();


        $(function() {
            validate_form();

            function validate_form() {

                //xử lý validate
                $("#frm-create-product").validate({
                    // errorPlacement: function(error, element) {
                    //     var place = element.closest('.form-group');
                    //     if (!place.get(0)) {
                    //         place = element;
                    //     }
                    //     if (place.get(0).type === 'checkbox') {
                    //         place = element.parent();
                    //     }
                    //     if (error.text() !== '') {
                    //         place.before(error);
                    //     }
                    //     console.log(error, element)
                    // },
                    rules: {
                        name: "required",
                        // 'category_item[]': {
                        //     required: true,
                        //     minlength: 1
                        // },
                        price: {
                            required: function(element) {
                                return $('input:radio[name="price_type"]:checked').val() == 'price';
                            },
                            number: function(element) {
                                return $('input:radio[name="price_type"]:checked').val() == 'price';
                            },
                            // min: 1,
                        },
                        category_id: {
                            required: true
                        },
                    },
                    messages: {
                        name: "Enter Name",
                        'category_item[]': "Select category",
                        price: {
                            required: "Enter price",
                            required: "Enter number only",
                            // min: "Enter price > 0"
                        },
                        category_id: {
                            required: "Select category"
                        },
                    },
                    errorElement: 'div',
                    errorLabelContainer: '.errorTxt',
                    invalidHandler: function(event, validator) {
                        $('html, body').animate({
                            scrollTop: 0
                        }, 500);
                    }
                });
            }
        });
    </script>
@endpush
