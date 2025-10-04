@extends('backend.layouts.master')
@section('seo')
    @php
        $title_head = 'Sản phẩm';
        $seo = [
            'title' => $title_head . ' | ' . Helpers::get_option_minhnn('seo-title-add'),
            'keywords' => Helpers::get_option_minhnn('seo-keywords-add'),
            'description' => Helpers::get_option_minhnn('seo-description-add'),
            'og_title' => 'List Category Product | ' . Helpers::get_option_minhnn('seo-title-add'),
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

            {{-- begin::Row --}}
            <div class="row">
                <div class="col-md-12">

                    {{-- card --}}
                    <div class="card card-primary card-outline mb-4">

                        {{-- card-header --}}
                        <div class="card-header">
                            <h3 class="card-title">List</h3>
                        </div>

                        {{-- card-body --}}
                        <div class="card-body">

                            <div class="d-flex flex-column flex-lg-row justify-content-between">

                                @include('backend.partials.button_add_delete', ['type' => 'product', 'route' => route('admin.product.create')])

                                <div class="w-lg-50 mt-3 mt-lg-0">
                                    <form method="GET" action="" id="frm-filter-post" class="form-inline">
                                        <div class="d-flex">
                                            @php
                                                $categories = App\Models\Backend\Category::select('id', 'name')->where('type', 'product')->orderByDesc('sort')->get();
                                            @endphp
                                            <select class="form-select custom-select me-2" name="category_id">
                                                <option value="">@lang('admin.category')</option>
                                                @foreach ($categories as $item)
                                                    <option value="{{ $item->id }}" {{ request('category_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="name" id="name" placeholder="@lang('admin.Keyword')" value="{{ request('name') }}">
                                                <button type="submit" class="btn btn-outline-primary" id="button-addon2"><i class="fa-regular fa-magnifying-glass"></i> @lang('admin.Search')</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center my-4">
                                <div>
                                    <b>@lang('admin.total')</b>: <span class="fw-bold text-red">{{ $total_item ?? 0 }}</span> @lang('admin.news')
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered list-data v-center" id="table_index">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width:50px">
                                                <div class="icheck-info d-inline">
                                                    <input type="checkbox" id="selectall" onclick="select_all()">
                                                    <label for="selectall">
                                                    </label>
                                                </div>
                                            </th>
                                            <th scope="col" class="text-center" style="width:100px">Ưu tiên</th>
                                            <th scope="col" class="text-center">Tên sản phẩm</th>
                                            <th scope="col" class="text-center">Hình ảnh</th>
                                            <th scope="col" class="text-center">Danh mục</th>
                                            <th scope="col" class="text-center">Ngày</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($products as $item)
                                            <tr>
                                                <td class="text-center">
                                                    <div class="icheck-info d-inline">
                                                        <input type="checkbox" id="{{ $item->id }}" name="chk_list[]" value="{{ $item->id }}">
                                                        <label for="{{ $item->id }}"></label>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <input type="text" id="sort" class="form-control quick_change_value text-center" data-id="{{ $item->id }}" data-model="{{ get_class($item) }}" value="{{ $item->sort }}" reload-on-change>
                                                </td>
                                                <td>
                                                    <a class="row-title mr-3" href="{{ route('admin.product.edit', [$item->id]) }}">
                                                        <b>{{ $item->name }}</b>
                                                    </a>
                                                    <br>
                                                    <a class="link to-link fw-bold" href="{{ route('product.detail', [$item->slug, $item->id]) }}" target="_blank">
                                                        <span>URL: </span>{{ route('product.detail', [$item->slug, $item->id]) }}
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    @if ($item->image != '')
                                                        <img src="{{ $item->image }}" style="height: 70px;">
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @php
                                                        $categories = $item->categories;
                                                    @endphp
                                                    @foreach ($categories as $k => $category)
                                                        <a class="link" target="_blank" href="{{ route('admin.product-category.edit', $category->id) }}">{{ $category->name }}</a> </br>
                                                    @endforeach
                                                </td>

                                                <td class="text-center">
                                                    {{-- <input type="checkbox" id="hot" class="quick_change_value" @checked($item->hot == 1) value="1" value-off="0" data-id="{{ $item->id }}" data-model="{{ get_class($item) }}" data-toggle="toggle" data-on="@lang('admin.hot')" data-off="@lang('admin.no')" data-onstyle="danger" data-offstyle="light"> --}}
                                                    <p class="my-2">{{ $item->updated_at }}</p>
                                                    <input type="checkbox" id="status" class="quick_change_value" @checked($item->status == 1) value="1" value-off="0" data-id="{{ $item->id }}" data-model="{{ get_class($item) }}" data-toggle="toggle" data-on="@lang('admin.publish')" data-off="@lang('admin.draft')" data-onstyle="success" data-offstyle="light">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        {{-- card-footer --}}
                        {{ $products->links('backend.pagination.custom') }}
                    </div>
                    {{-- end::card --}}
                </div>
            </div>
            {{-- end::Row --}}
        </div>
    </div>
    {{-- end::App Content --}}
@endsection
