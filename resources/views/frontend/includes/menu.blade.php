@php
    $lc = app()->getLocale();
    $headerMenu = \App\Models\Frontend\Menu::where('name', 'Menu-main')->first();
@endphp

<nav class="navbar sticky-top navbar-expand-lg navbar-dark main-menu py-1 custom-toggler">

    <div class="container">
        <button class="custom-toggler navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span> Menu
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">

                @if ($headerMenu)
                    @foreach ($headerMenu->items as $item)
                        @php $hasChild = $item->child()->exists(); @endphp
                        @if ($hasChild != 1)
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="{{ $item->link }}">{{ $item->label }}</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                                    {{ $item->label }}
                                </a>
                                <ul class="dropdown-menu">
                                    @foreach ($item->child as $item2)
                                        <li>
                                            <a class="dropdown-item" href="{{ $item->link }}">{{ $item2->label }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endforeach
                @endif

                {{-- <li class="nav-item">
                    <a class="nav-link" href="{{ route('cart') }}">
                        <i class="fa-regular fa-cart-shopping"></i>
                        <span class="navbar__cart-quantity" id="CartCount">{{ Cart::count() }}</span>
                    </a>
                </li> --}}
            </ul>

            <form action="{{ route('search') }}" class="form-inline my-2 my-lg-0">
                {{-- <a href="{{ route('cart') }}" class="btn btn-success my-2 my-sm-0">
                    <i class="fa-regular fa-cart-shopping"></i> {{ Cart::count() }}
                </a> --}}

                <a class="nav-link d-none d-lg-block" href="{{ route('cart') }}">
                    <i class="fa-regular fa-cart-shopping text-white"></i>
                    <span class="navbar__cart-quantity" id="CartCount">{{ Cart::count() }}</span>
                </a>
                <input class="form-control mr-sm-2" type="search" placeholder="Tìm kiếm" name="keyword" value="{{ request('keyword') }}">
                <button type="submit" class="btn btn-success my-2 my-sm-0"><i class="fa fa-search fa-fw"></i>
                </button>
            </form>
        </div>


        <a class="nav-link d-block d-lg-none" href="{{ route('cart') }}">
            <i class="fa-regular fa-cart-shopping text-white"></i>
            <span class="navbar__cart-quantity" id="CartCount">{{ Cart::count() }}</span>
        </a>
    </div>
</nav>


@push('scripts')
    {{-- <script>
        $('.dropdown-link').on('click', function() {
            console.log(123);
            window.location.href = $(this).attr('href');
        });
    </script> --}}
@endpush
