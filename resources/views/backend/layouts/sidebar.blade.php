@php
    $segment_check = Request::segment(2);
    $segment_check3 = Request::segment(3);

    $menus = \App\Models\Backend\AdminMenu::getListVisible();
    // dd($menus);
    $AdminMenu = new App\Models\Backend\AdminMenu();

    $user = Auth::user();

    if ($user) {
        $user_role = Auth::user()->roles()->first();
    }

    // Hiển thị danh sách route names
    // dd($routeNames);
    // dd(Route::getRoutes()->toArray());
    $routeNames = collect(Route::getRoutes())
        ->filter(function ($route) {
            return str_starts_with($route->uri(), 'admin'); // Lọc route có prefix 'admin'
        })
        ->map(function ($route) {
            return $route->getName(); // Lấy tên route
        })
        ->filter()
        ->values()
        ->toArray(); // Loại bỏ null và chuyển thành mảng
    // Hiển thị danh sách route names
    // dd($routeNames);
@endphp


@if ($user)
    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">

        {{-- begin::Sidebar Brand --}}
        <div class="sidebar-brand">
            {{-- begin::Brand Link --}}
            <a href="{{ route('admin.dashboard') }}" class="brand-link">
                {{-- begin::Brand Image --}}
                <img src="{{ get_image(setting_option('logo')) }}" alt="AdminLTE Logo" class="brand-image opacity-75 shadow" />
                {{-- begin::Brand Text --}}
                <span class="brand-text fw-light">GetAZ</span>
            </a>
        </div>
        {{-- end::Sidebar Brand --}}


        {{-- begin::Sidebar Wrapper --}}
        <div class="sidebar-wrapper">
            <nav class="mt-2">

                {{-- begin::Sidebar Menu --}}
                <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link">
                            {{-- <i class="nav-icon bi bi-grip-horizontal"></i> --}}
                            <i class="nav-icon bi bi-speedometer"></i>
                            {{-- <i class="nav-icon fas fa-tachometer-alt"></i> --}}
                            <p>{!! __('admin.dashboard') !!}</p>
                        </a>
                    </li>

                    {{-- <li class="nav-item">
                        <a href="./generate/theme.html" class="nav-link">
                            <i class="nav-icon bi bi-palette"></i>
                            <p>Theme Generate</p>
                        </a>
                    </li> --}}

                    <li class="nav-item">
                        <a href="{{ route('index') }}" target="_blank" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>{!! __('admin.home') !!}</p>
                        </a>
                    </li>


                    @if (count($menus))
                        {{-- Level 0 --}}
                        @foreach ($menus[0] as $level0)
                            {{-- LEvel 1 --}}
                            @if (!empty($menus[$level0->id]) && $level0->hidden == 0)
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon {{ $level0->icon }}"></i>
                                        <p>
                                            {!! __($level0->title) !!} <i class="nav-arrow bi bi-chevron-right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @foreach ($menus[$level0->id] as $level1)
                                            <li class="nav-item">
                                                <a href="{{ $level1->uri ? route($level1->uri) : '#' }}" class="nav-link {{ $AdminMenu::checkUrlIsChild(url()->current(), route($level1->uri)) ? 'active' : '' }}">
                                                    <i class="nav-icon {{ $level1->icon }}"></i>
                                                    <p>{!! __($level1->title) !!}</p>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                @if ($level0->hidden == 0)
                                    <li class="nav-item">
                                        <a href="{{ $level0->uri ? route($level0->uri) : '#' }}" class="nav-link {{ $AdminMenu::checkUrlIsChild(url()->current(), route($level0->uri)) ? 'active' : '' }}">
                                            <i class="nav-icon {{ $level0->icon }}"></i>
                                            <p>{!! __($level0->title) !!}</p>
                                        </a>
                                    </li>
                                @endif
                            @endif
                            {{-- LEvel 1  --}}
                        @endforeach
                        {{-- Level 0 --}}
                    @endif

                    <li class="nav-header">SETTING</li>

                    @php
                        // dd(Route::currentRouteName());
                        $route_active = ['admin.user.index', 'admin.role.index', 'admin.permission.index'];
                    @endphp

                    @if ($user->admin_level == '99999' && $user_role->name == 'Administrator')
                        <li class="nav-item {{ in_array(Route::currentRouteName(), $route_active) ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-user-friends"></i>
                                <p>
                                    @lang('admin.user') <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.user.index') }}" class="nav-link {{ Route::currentRouteName() == 'admin.user.index' ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-angle-right"></i>
                                        <p> @lang('admin.user') </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.role.index') }}" class="nav-link {{ Route::currentRouteName() == 'admin.role.index' ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-angle-right"></i>
                                        <p>@lang('role')</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.permission.index') }}" class="nav-link {{ Route::currentRouteName() == 'admin.permission.index' ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-angle-right"></i>
                                        <p>@lang('permission')</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    @php
                        // dd(Route::currentRouteName());
                        $route_active = ['admin.theme-option', 'admin.css.get'];
                    @endphp

                    <li class="nav-item {{ in_array(Route::currentRouteName(), $route_active) ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa-light fa-gear"></i>
                            <p>
                                Setting <i class="nav-arrow bi bi-chevron-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.theme-option') }}" class="nav-link {{ Route::currentRouteName() == 'admin.theme-option' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-angle-right"></i>
                                    <p>Theme Option</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.css.get') }}" class="nav-link {{ Route::currentRouteName() == 'admin.css.get' ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-angle-right"></i>
                                    <p>Theme CSS</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.change-password') }}" class="nav-link">
                            <i class="nav-icon fa fa-user" aria-hidden="true"></i>
                            <p>@lang('admin.account')</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.logout') }}" class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>@lang('admin.logout')</p>
                        </a>
                    </li>

                </ul>
            </nav>
            {{-- /.sidebar-menu --}}
        </div>
        {{-- /.sidebar --}}
    </aside>
@endif
