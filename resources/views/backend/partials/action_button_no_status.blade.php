@php
    $status = $status ?? 1;
    $date_create = isset($created_at) ? $created_at : date('Y-m-d H:i:s');
    $date_update = isset($updated_at) ? $updated_at : date('Y-m-d H:i:s');
@endphp

<div class="card card-danger card-outline mb-4">

    {{-- header --}}
    <div class="card-header">
        <h3 class="card-title">@lang('admin.publish')</h3>
    </div>

    {{-- card-body --}}
    <div class="card-body">
        <div class="mb-3">
            <label for="created_at" class="form-label">@lang('admin.created date'):</label>
            <div class="input-group">
                <input type="text" id="created_at" name="created_at" class="form-control" value="{{ $date_create }}">
                <span class="input-group-text input-append-date">
                    <i class="far fa-calendar-alt"></i>
                </span>
            </div>
        </div>

        <div class="mb-3">
            <label for="updated_at" class="form-label">@lang('admin.updated date'):</label>
            <div class="input-group">
                <input type="text" id="updated_at" name="updated_at" class="form-control" value="{{ $date_update }}">
                <span class="input-group-text input-append-date">
                    <i class="far fa-calendar-alt"></i>
                </span>
            </div>
        </div>

        {{-- <div class="form-group text-right">
            <button type="submit" name="submit" value="save" id="submit_form_save" class="btn btn-primary mt-3">@lang('admin.save')</button>
            <button type="submit" name="submit" value="apply" id="submit_form_save_edit" class="btn btn-success mt-3">@lang('admin.save edit')</button>
        </div> --}}
    </div>

    {{-- card-footer --}}
    <div class="card-footer text-end">
        <button type="submit" name="submit" value="save" id="submit_form_save" class="btn btn-primary">@lang('admin.save')</button>
        <button type="submit" name="submit" value="apply" id="submit_form_save_edit" class="btn btn-warning">@lang('admin.save & edit')</button>
    </div>
</div>


@push('scripts')
    <script>
        var optional_config = {
            dateFormat: "Y-m-d",
        }

        $("#created_at").flatpickr(optional_config);
        $("#updated_at").flatpickr(optional_config);

        $('.input-append-date').on('click', function() {
            $(this).siblings('input').focus();
        });
    </script>
@endpush
