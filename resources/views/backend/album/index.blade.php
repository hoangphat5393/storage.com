@extends('backend.layouts.master')
@section('seo')
    @php
        $title_head = __('admin.album');
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

@push('style')
    {{-- <link rel="stylesheet" href="{{ asset('plugin/DataTables/datatables.min.css') }}"> --}}
@endpush

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
                                @include('backend.partials.button_add_delete', ['type' => 'album', 'route' => route('admin.album.create')])
                                <div>
                                    <form method="GET" action="" id="frm-filter-post" class="form-inline">
                                        <div class="input-group mb-3">
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
                                    <b>@lang('admin.total')</b>: <span class="fw-bold text-red">{{ $total_item ?? 0 }}</span> @lang('admin.album')
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered list-data v-center" id="table_index">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width:50px">
                                                <div class="icheck-info d-inline">
                                                    <input type="checkbox" id="selectall" onclick="select_all()">
                                                    <label for="selectall"></label>
                                                </div>
                                            </th>
                                            <th scope="col" class="text-center" style="width:100px">@lang('admin.sort')</th>
                                            <th scope="col" class="text-center">Short code</th>
                                            <th scope="col" class="text-center">@lang('name')</th>
                                            <th scope="col" class="text-center">@lang('created date')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($album as $item)
                                            <tr>
                                                <td class="text-center">
                                                    <div class="icheck-info d-inline">
                                                        <input type="checkbox" id="{{ $item->id }}" name="seq_list[]" value="{{ $item->id }}">
                                                        <label for="{{ $item->id }}"></label>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <input type="text" id="sort" class="form-control quick_change_value text-center" data-id="{{ $item->id }}" data-model="{{ get_class($item) }}" value="{{ $item->sort }}" reload-on-change>
                                                </td>
                                                <td class="text-center">
                                                    [Ablum id="{{ $item->id }}" items="{{ $item->items->count() }}"]
                                                </td>
                                                <td class="text-center">
                                                    <a class="row-title fw-bold" href="{{ route('admin.album.edit', $item->id) }}">
                                                        {{ $item->name }}
                                                        {{-- | {{ $item->name_en }} --}}
                                                    </a>
                                                </td>

                                                <td class="text-center">
                                                    {{ $item->updated_at }}
                                                    <br>
                                                    <input type="checkbox" id="status" class="quick_change_value" @checked($item->status == 1) value="1" value-off="0" data-id="{{ $item->id }}" data-model="{{ get_class($item) }}" data-toggle="toggle" data-on="@lang('admin.publish')" data-off="@lang('admin.draft')" data-onstyle="success" data-offstyle="light">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="fr">
                                {!! $album->links() !!}
                            </div>

                        </div> <!-- /.card-body -->
                    </div><!-- /.card -->
                </div> <!-- /.col -->
            </div> <!-- /.row -->
        </div> <!-- /.container-fluid -->
    </div>
@endsection

@push('scripts')
    {{-- <script src="{{ asset('plugin/DataTables/datatables.min.js') }}"></script> --}}
@endpush
