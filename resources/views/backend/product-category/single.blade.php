@extends('backend.layouts.master')
@php
    $lc = app()->getLocale();
    if (isset($category)) {
        extract($category->getAttributes());
        // if ($gallery) {
        //     $gallery = unserialize($gallery);
        // }
    }

    $title_head = $name ?? __('admin.product category');
    $id = $id ?? 0;

    if (request()->route()->named('admin.product-category.create')) {
        $form_action = route('admin.product-category.store'); // Create news
    } else {
        $form_action = route('admin.product-category.update', $id); // Update news
    }
@endphp

@section('seo')
    @php
        $seo = [
            'title' => $title_head,
            'keywords' => '',
            'description' => '',
            'og_title' => $title_head,
            'og_description' => '',
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

            <form action="{{ $form_action }}" method="POST" id="frm-create-category" enctype="multipart/form-data">
                @if (!request()->route()->named('admin.product-category.create'))
                    @method('PUT')
                @endif
                @csrf
                <input type="hidden" name="id" value="{{ $id ?? '' }}">

                <div class="row">

                    {{-- <div class="col-12">
                        <div class="callout callout-info">
                            For detailed documentation of Form visit
                            <a href="https://getbootstrap.com/docs/5.3/forms/overview/" target="_blank" rel="noopener noreferrer" class="callout-link">
                                Bootstrap Form
                            </a>
                        </div>
                    </div> --}}

                    <div class="col-md-9">

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
                                    <label for="slug" class="form-label">@lang('admin.slug')</label>
                                    <input type="text" class="form-control" id="slug" name="slug" placeholder="slug" value="{{ $slug ?? '' }}">
                                    {{-- <div id="nameHelp" class="form-text">
                                        We'll never share your email with anyone else.
                                    </div> --}}

                                    @if ($id > 0)
                                        <p class="my-2">
                                            <strong class="text-primary">Link Vi:</strong>
                                            <u><i><a href="{{ route('page', $slug) }}" target="_blank" class="text-red">{{ route('page', $slug) }}</a></i></u>
                                        </p>
                                    @endif
                                </div>

                                {{-- <ul class="nav nav-tabs hidden" id="tabLang" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="vi-tab" data-toggle="tab" href="#vi" role="tab" aria-controls="vi" aria-selected="true">Tiếng việt</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="en-tab" data-toggle="tab" href="#en" role="tab" aria-controls="en" aria-selected="false">Tiếng Anh</a>
                                    </li>
                                </ul> --}}

                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="vi" role="tabpanel" aria-labelledby="vi-tab">
                                        <div class="mb-3">
                                            <label for="name">Tên chuyên mục</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Tiêu đề" value="{{ $name ?? '' }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="description">Trích dẫn</label>
                                            <textarea id="description" name="description">{!! $description ?? '' !!}</textarea>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-info card-outline mb-4">
                            <div class="card-header">
                                <h5>@lang('Infomation')</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="parent" class="col-form-label">@lang('Select parent category')</label>
                                    @include('backend.product-category.select-category', ['parent' => $parent ?? 0])
                                </div>
                                <div class="mb-3">
                                    <label for="sort" class="col-form-label">@lang('admin.sort')</label>
                                    <input type="text" class="form-control" id="sort" name="sort" value="{{ $sort ?? 0 }}">
                                </div>
                            </div>
                        </div>
                    </div> <!-- /.col-9 -->

                    <div class="col-md-3">
                        @include('backend.partials.action_button')

                        {{-- @include('backend.partials.image', ['title' => 'Icon ', 'id' => 'icon-img', 'name' => 'icon', 'image' => $icon ?? '']) --}}

                        @include('backend.partials.image', ['title' => 'Hình ảnh', 'id' => 'img', 'name' => 'image', 'image' => $image ?? ''])
                    </div>
                </div>
                {{-- end::row --}}

                {{-- SEO --}}
                {{-- <div class="row">
                    <div class="col-12 col-md-9">
                        @include('backend.partials.form-seo')
                    </div>
                </div> --}}
                {{-- END SEO --}}

            </form>
        </div>
    </div>
    {{-- end::App Content --}}
@endsection

@push('scripts')
    <script type="text/javascript">
        $(function() {

            editorQuote('description');
            editorQuote('description_en');

            editor('content');
            editor('content_en');

            //Date range picker
            // $('#reservationdate').datetimepicker({
            //     format: 'YYYY-MM-DD hh:mm:ss'
            // });

            //xử lý validate
            $("#frm-create-category").validate({
                rules: {
                    name: "required",
                },
                messages: {
                    name: "Vui lòng nhập tên",
                },
                errorElement: 'div',
                errorLabelContainer: '.errorTxt',
                invalidHandler: function(event, validator) {
                    $('html, body').animate({
                        scrollTop: 0
                    }, 500);
                }
            });
        });
    </script>
@endpush
