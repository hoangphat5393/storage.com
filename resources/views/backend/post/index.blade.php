@extends('backend.layouts.master')
@section('seo')
    @php
        $title_head = __('admin.news');
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
                            <h3 class="card-title">List</h3>
                        </div>

                        {{-- card-body --}}
                        <div class="card-body">

                            <div class="d-flex flex-column flex-lg-row justify-content-between">

                                @include('backend.partials.button_add_delete', ['type' => 'page', 'route' => route('admin.post.create')])

                                <div>
                                    <form method="GET" action="" id="frm-filter-post" class="form-inline">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="name" name="name" placeholder="@lang('admin.name')" aria-label="@lang('admin.keyword')" aria-describedby="name" value="{{ request('name') }}">
                                            <button class="btn btn-outline-primary" type="submit" id="button-addon2">
                                                <i class="fa-regular fa-magnifying-glass"></i> @lang('admin.search')
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between my-4">
                                <div>
                                    <b>@lang('admin.total')</b>: <span class="fw-bold text-red">{{ $total_item ?? 0 }}</span> @lang('admin.news')
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered list-data" id="table_index">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width:50px">
                                                <div class="icheck-info d-inline">
                                                    <input type="checkbox" id="selectall" onclick="select_all()">
                                                    <label for="selectall"></label>
                                                </div>
                                            </th>
                                            <th style="width: 10px">#</th>
                                            <th class="text-center" style="width:100px">@lang('admin.priority')</th>
                                            <th class="text-center">@lang('admin.name')</th>
                                            <th class="text-center">@lang('admin.thumbnail')</th>
                                            <th class="text-center">@lang('admin.created by')</th>
                                            <th class="text-center">@lang('admin.created date')</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($posts as $item)
                                            <tr class="align-middle">
                                                <td class="text-center">
                                                    <div class="icheck-info d-inline">
                                                        <input type="checkbox" id="{{ $item->id }}" name="seq_list[]" value="{{ $item->id }}">
                                                        <label for="{{ $item->id }}"></label>
                                                    </div>
                                                </td>
                                                <td>{{ $item->id }}.</td>
                                                <td class="text-center">
                                                    <input type="text" id="sort" class="form-control quick_change_value text-center" data-id="{{ $item->id }}" data-model="{{ get_class($item) }}" value="{{ $item->sort }}" reload-on-change>
                                                </td>
                                                <td>
                                                    <a class="row-title fw-bold" href="{{ route('admin.post.edit', $item->id) }}">
                                                        {{ $item->name }}
                                                    </a>
                                                    <br>
                                                    <a class="fw-bold text-danger" href="{{ route('news.detail', [$item->slug, $item->id]) }}" target="_blank">
                                                        <span>URL: </span>{{ route('news.detail', [$item->slug, $item->id]) }}
                                                    </a>
                                                </td>

                                                <td class="text-center">
                                                    <img src="{{ get_image($item->image) }}" style="height: 70px;">
                                                </td>
                                                <td class="text-center">
                                                    <div class="w-fit-content mx-auto">{{ $item->user->name }}</div>
                                                </td>
                                                <td class="text-center">
                                                    {{ $item->updated_at }}
                                                    <br>
                                                    <input type="checkbox" id="status" class="quick_change_value" @checked($item->status == 1) value="1" value-off="0" data-id="{{ $item->id }}" data-model="{{ get_class($item) }}" data-toggle="toggle" data-on="@lang('admin.publish')" data-off="@lang('admin.draft')" data-onstyle="success" data-offstyle="light">
                                                    {{-- <a href="{{ route('admin.post.destroy', $item->id) }}" class="btn btn-danger"><i class="fa-duotone fa-trash"></i></a> --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- card-footer --}}
                        {{ $posts->links('backend.pagination.custom') }}
                    </div>
                    {{-- end::card --}}
                </div>
            </div>
            {{-- end::Row --}}
        </div>
    </div>
    {{-- end::App Content --}}
@endsection
