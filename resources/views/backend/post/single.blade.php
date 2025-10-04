@extends('backend.layouts.master')
@php
    $lc = app()->getLocale();
    if (isset($post)) {
        extract($post->getAttributes());
        // if ($gallery) {
        //     $gallery = unserialize($gallery);
        // }
    }

    $title_head = $name ?? __('Add news');
    $id = $id ?? 0;

    if (request()->route()->named('admin.post.create')) {
        $form_action = route('admin.post.store'); // Create news
    } else {
        $form_action = route('admin.post.update', $id); // Update news
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

            <form id="formEdit" action="{{ $form_action }}" method="POST" enctype="multipart/form-data">
                @if (!request()->route()->named('admin.post.create'))
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
                                    <label for="slug" class="form-label">@lang('admin.slug')</label>
                                    <input type="text" class="form-control" id="slug" name="slug" placeholder="slug" value="{{ $slug ?? '' }}">
                                    {{-- <div id="nameHelp" class="form-text">
                                        We'll never share your email with anyone else.
                                    </div> --}}

                                    @if ($id > 0)
                                        <p class="my-2">
                                            <strong class="text-primary">Link Vi:</strong>
                                            <u><i><a href="{{ route('news.detail', [$slug, $id]) }}" target="_blank" class="text-red">{{ route('news.detail', [$slug, $id]) }}</a></i></u>
                                        </p>
                                    @endif
                                </div>

                                {{-- <ul class="nav nav-tabs d-none" id="tabLang" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="vi-tab" data-toggle="tab" href="#vi" role="tab" aria-controls="vi" aria-selected="true">@lang('admin.Vietnamese')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="en-tab" data-toggle="tab" href="#en" role="tab" aria-controls="en" aria-selected="false">@lang('admin.English')</a>
                                    </li>
                                </ul> --}}

                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="vi" role="tabpanel" aria-labelledby="vi-tab">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">@lang('admin.name')</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="@lang('admin.name')" value="{{ $name ?? '' }}">
                                        </div>
                                        @php
                                            $quote_arr = ['id' => 'description', 'label' => 'Description', 'name' => 'description', 'description' => $description ?? ''];
                                            $content_arr = ['id' => 'content', 'label' => __('admin.content'), 'name' => 'content', 'content' => $content ?? ''];
                                        @endphp
                                        @include('backend.partials.quote', $quote_arr)
                                        @include('backend.partials.content', $content_arr)
                                    </div>
                                    {{-- <div class="tab-pane fade" id="en" role="tabpanel" aria-labelledby="en-tab">
                                        <div class="mb-3">
                                            <label for="name_en" class="form-label">@lang('admin.title')</label>
                                            <input type="text" class="form-control" id="name_en" name="name_en" placeholder="Name EN" value="{{ $name_en ?? '' }}">
                                        </div>
                                        @php
                                            $quote_arr = ['id' => 'description_en', 'label' => 'Description', 'name' => 'description_en', 'description' => $description_en ?? ''];
                                            $content_arr = ['id' => 'content_en', 'label' => __('admin.content'), 'name' => 'content_en', 'content' => $content_en ?? ''];
                                        @endphp
                                        @include('backend.partials.quote', $quote_arr)
                                        @include('backend.partials.content', $content_arr)
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                        {{-- end::card --}}

                        <div class="mb-3 d-none">
                            <label for="type" class="form-label">@lang('admin.name')</label>
                            <input type="hidden" class="form-control" id="type" name="type" value="post">
                        </div>

                        <div class="card card-info card-outline mb-4">
                            <div class="card-header">
                                <h5>@lang('Infomation')</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="sort" class="col-form-label text-lg-right">@lang('Sort')</label>
                                    <input type="text" class="form-control" id="sort" name="sort" value="{{ $sort ?? 0 }}">
                                </div>
                            </div>
                        </div>

                        {{-- <div class="card">
                            <div class="card-header">Gallery</div>
                            <div class="card-body">
                                <div class="form-group">
                                    @include('admin.partials.galleries', ['gallery_images' => $gallery ?? ''])
                                </div>
                            </div>
                        </div> --}}
                    </div>

                    <div class="col-md-3">
                        @include('backend.partials.action_button')

                        {{-- SELECT CATEGORY --}}
                        {{-- <div class="card card-primary card-outline mb-4">
                            <div class="card-header">
                                <h4>@lang('admin.category')</h4>
                            </div>
                            <div class="card-body max-vh-75">
                                <div class="inside clear">
                                    @php
                                        $array_checked = isset($edit_data) ? $edit_data->categories->pluck('id')->toArray() : [];
                                        $category_type = 'post';
                                    @endphp
                                    @include('backend.partials.category-item')
                                </div>
                            </div>
                        </div> --}}
                        {{-- END SELECT CATEGORY --}}

                        @include('backend.partials.image', ['title' => __('admin.thumbnail'), 'id' => 'img', 'name' => 'image', 'image' => $image ?? ''])
                        {{-- @include('backend.partials.image', ['title' => 'Hình ảnh Banner', 'id' => 'cover-img', 'name' => 'cover', 'image' => $cover ?? '']) --}}
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
    {{-- end::App Content --}}
@endsection

@push('scripts')
    <script type="text/javascript">
        $(function() {
            // $('.slug_slugify').slugify('.title_slugify');

            editorQuote('description');
            // editorQuote('description_en');
            editor('content');
            // editor('content_en');

            $('#thumbnail_file').change(function(evt) {
                $("#thumbnail_file_link").val($(this).val());
                $("#thumbnail_file_link").attr("value", $(this).val());
            });

            //xử lý validate
            $("#formEdit").validate({
                rules: {
                    name: "required",
                    'category[]': {
                        required: true,
                        minlength: 1
                    }
                },
                messages: {
                    name: "Nhập tiêu đề tin",
                    'category[]': "Chọn thể loại tin",
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
