<ul class="list-inline">
    <li class="nav-item list-inline-item">
        <a class="btn btn-danger mr-2" onclick="delete_id('{{ $type }}')" href="javascript:void(0)"><i class="fas fa-trash"></i> @lang('admin.delete')</a>
    </li>
    <li class="nav-item list-inline-item">
        <a class="btn btn-primary mr-2" href="{{ $route }}"><i class="fas fa-plus"></i> @lang('admin.create new')</a>
    </li>
    <li class="nav-item list-inline-item">
        <a class="btn btn-primary" onclick="replicate_id('{{ $type }}')" href="javascript:void(0)"><i class="fa-regular fa-copy"></i> @lang('admin.copy')</a>
    </li>
</ul>
