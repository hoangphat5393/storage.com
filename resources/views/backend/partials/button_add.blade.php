<ul class="d-flex">
    <li class="nav-item">
        <a class="btn btn-danger mr-2" onclick="delete_id('{{ $type }}')" href="javascript:void(0)"><i class="fas fa-trash"></i> @lang('admin.Delete')</a>
    </li>
    <li class="nav-item">
        <a class="btn btn-primary mr-2" href="{{ $route }}"><i class="fas fa-plus"></i> @lang('admin.create_new')</a>
    </li>
</ul>
