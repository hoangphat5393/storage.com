@php
    // if (Auth::check()) {
    //     $user = Auth::user();
    //     $avatar = public_path('img/users/avatar/') . $user->avatar;
    // }
    $lc = app()->getLocale();
@endphp

<header>
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center my-2">
            <div class="col-4 col-lg-2 text-center">
                <a href="{{ route('index') }}" title="{{ setting_option('webtitle') }}">
                    <img src="{{ setting_option('logo') }}" alt="" class="img-fluid logo">
                </a>
                <br>
                <p class="text-1 mb-0">
                    <strong>VẬT TƯ NÔNG NGHIỆP 58</strong>
                </p>
            </div>
            <div class="col-7 col-lg-7 text-center font-weight-bold">
                <h1 class="d-none d-lg-block">Cửa Hàng Vật Tư Nông Nghiệp <span>58</span></h1>
                <p class="text-2 slogan mb-0">{{ setting_option('slogan') }}</p>
                <p class="d-none d-lg-block text-3 mb-0">{{ setting_option('address') }}</p>
            </div>
            <div class="col-lg-2 text-center d-none d-lg-block">
                <a href="tel:{{ setting_option('phone') }}" class="btn btn-call" title="Gọi điện"><i class="fa fa-phone fa-fw"></i> {{ setting_option('phone') }}</a>
            </div>
        </div>
    </div>
</header>

<header id="header" class="header d-none">
    <div class="container">
        <ul class="nav justify-content-end">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{ Route::localizedUrl('vi') }}">@lang('Viet Nam')</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ Route::localizedUrl('en') }}">@lang('English')</a>
            </li>

        </ul>
    </div>

    @php
        $headerMenu = \App\Models\Frontend\Menu::where('name', 'Menu-main-' . $lc)->first();
    @endphp

    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('index') }}">
                <img src="{{ get_image(setting_option('logo')) }}" class="logo" alt="{{ setting_option('webtitle') }}" style="height:76px">
            </a>
            <div class="d-none d-lg-block">
                <div class="d-flex camp-group-block">
                    <div class="left-block fw-semibold">
                        @lang('Create your campaign')
                    </div>
                    <a href="{{ route('page', 'donate') }}" class="d-block right-block fw-bold">
                        @lang('Donate now')
                    </a>
                </div>
            </div>
            <button class="navbar-toggler d-block d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        @if ($headerMenu)
                            @foreach ($headerMenu->items as $item)
                                @php $hasChild = $item->child()->exists(); @endphp
                                @if ($hasChild != 1)
                                    <li class="nav-item">
                                        <a class="nav-link" aria-current="page" href="{{ $item->link }}">{{ $item->label }}</a>
                                    </li>
                                @else
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            {{ $item->label }}
                                        </a>
                                        <ul class="dropdown-menu">
                                            @foreach ($item->child as $item2)
                                                <li><a class="dropdown-item" href="{{ $item->link }}">{{ $item2->label }}</a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    </ul>

                    <form class="d-flex" role="search" method="get" action="{{ route('search') }}">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control input-search" placeholder="@lang('Search')" aria-label="@lang('Search')">
                            <button type="submit" class="input-group-text btn-search" id="search">
                                <i class="fa-sharp fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </nav>
</header>
