{{-- <div class="row g-3 mb-3">
    <div class="col-md-6">
        <label for="name" class="form-label">@lang('admin.name')</label>
        <input type="text" class="form-control title_slugify" id="name" name="name" placeholder="@lang('admin.name')" value="{{ $name ?? '' }}">
    </div>
    <div class="col-md-6">
        <label for="supplier" class="form-label">@lang('admin.supplier')</label>
        <input type="text" class="form-control" id="supplier" name="supplier" placeholder="@lang('admin.supplier')" value="{{ $supplier ?? '' }}">
    </div>

    <div class="col-md-6">
        <label for="ip_address" class="form-label">@lang('admin.ip address')</label>
        <input type="text" class="form-control title_slugify" id="ip_address" name="ip_address" placeholder="@lang('admin.ip address')" value="{{ $ip_address ?? '' }}">
    </div>
    <div class="col-md-6">
        <label for="port" class="form-label">@lang('admin.port')</label>
        <input type="text" class="form-control title_slugify" id="port" name="port" placeholder="@lang('admin.port')" value="{{ $port ?? '' }}">
    </div>
</div> --}}

<div class="mb-3">
    <label for="name" class="form-label">@lang('admin.name')</label>
    <input type="text" class="form-control" id="name" name="name" placeholder="@lang('admin.name')" value="{{ $name ?? '' }}">
</div>

@php
    $quote_arr = ['id' => 'description', 'label' => 'Description', 'name' => 'description', 'description' => $description ?? ''];
    $content_arr = ['id' => 'content', 'label' => __('admin.content'), 'name' => 'content', 'content' => $content ?? ''];
@endphp

@include('backend.partials.quote', $quote_arr)
