@extends('backend.layouts.master')
@section('seo')
    @php
        $title_head = __('admin.product category');
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

            {{-- begin::Row --}}
            <div class="row">
                <div class="col-md-12">

                    {{-- card --}}
                    <div class="card card-primary card-outline mb-4">

                        {{-- card-header --}}
                        <div class="card-header">
                            <h3 class="card-title">{{ $title_head }} List</h3>
                        </div>

                        {{-- card-body --}}
                        <div class="card-body">

                            <div class="d-flex flex-column flex-lg-row align-items-center justify-content-between">
                                @include('backend.partials.button_add_delete', ['type' => 'product-categories', 'route' => route('admin.product-category.create')])
                                <div class="w-lg-50 mt-3 mt-lg-0">
                                    <form method="GET" action="" id="frm-filter-post" class="form-inline">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="name" name="name" placeholder="@lang('admin.name')" aria-label="@lang('admin.Keyword')" aria-describedby="name" value="{{ request('name') }}">
                                            <button class="btn btn-outline-primary" type="submit" id="button-addon2">
                                                <i class="fa-regular fa-magnifying-glass"></i> @lang('admin.search')
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between my-4">
                                <div>
                                    <b>@lang('admin.total')</b>: <span class="fw-bold text-red">{{ $total_item ?? 0 }}</span> @lang('admin.category')
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered v-center" id="table_index">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">
                                                <div class="icheck-info d-inline">
                                                    <input type="checkbox" id="selectall" onclick="select_all()">
                                                    <label for="selectall">
                                                    </label>
                                                </div>
                                            </th>
                                            <th scope="col" class="text-center" style="width:100px">STT</th>
                                            <th scope="col" class="text-center">@lang('admin.name')</th>
                                            <th scope="col" class="text-center">@lang('admin.image')</th>
                                            <th scope="col" class="text-center">@lang('admin.created date')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($categories->count())
                                            @include('backend.product-category.category_item', ['level' => 0, 'categories' => $categories])
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        {{-- card-footer --}}
                        {{ $categories->links('backend.pagination.custom') }}
                    </div>
                    {{-- end::card --}}
                </div>
            </div>
            {{-- end::Row --}}
        </div>
    </div>
    {{-- end::App Content --}}
@endsection
