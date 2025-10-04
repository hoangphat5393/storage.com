@extends('frontend.layouts.master')

@section('seo')
    @include('frontend.layouts.seo', $seo ?? [])
@endsection

@inject('ProductModel', 'App\Models\Frontend\Product')

@section('content')
    <main>

        {{-- Menu --}}
        @include('frontend.includes.menu')

        <div class="carts-content">
            <div class="cart_bg">
                <div class="container pt-4 pb-3 py-sm-4">

                    @if ($carts->count())
                        <div class="row">
                            <div class="col-12 col-lg-8 pt-sm-3">
                                {{-- <form action="{{ route('cart.checkout') }}" method="post" id="checkout_form" class="checkout_form"> --}}
                                {{-- @csrf --}}
                                {{-- <input type="hidden" name="cart_total" value="{{ Cart::total(2) }}"> --}}

                                {{-- CART TABLE --}}
                                <div class="table-container">
                                    <div class="table-responsive cart-table-include">
                                        @include('frontend.cart.cart-table')
                                    </div>
                                </div>

                                {{-- CUSTOMER INFO --}}
                                <div class="create-ac-content bg-light-gray">

                                    @include('frontend.cart.includes.customer-info')

                                    <div class="cart-btn">
                                        {{-- <button type="button" class="btn btn-info get_shipping_usps" title="Continue to shipping">Continue to shipping</button> --}}
                                        {{-- <a href="{{ url('cart') }}" class="btn btn-sm btn-info mt-3" title="Continue to shipping"><i class="fas fa-arrow-left"></i>&nbsp; BACK TO CART</a> --}}
                                    </div>
                                </div>

                                {{-- PAYMENT METHOD --}}
                                {{-- @include($templatePath . '.cart.includes.payment-method') --}}
                                {{-- </form> --}}
                                {{-- @include($templatePath . '.cart.includes.customer-info') --}}
                            </div>

                            {{-- SIDEBAR --}}
                            @include('frontend.cart.includes.cart-sidebar')
                            {{-- END SIDEBAR --}}
                        </div>
                    @else
                        <div class="alert alert-dark text-uppercase mt-5" role="alert">
                            <i class="ci-loudspeaker"></i> &nbsp;@lang('Cart is empty!')
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        $(document).on('click', '.cart__remove', function(event) {
            event.preventDefault();
            $(this).closest('.cart__row_item').remove();
            var rowId = $(this).attr('data');
            axios({
                method: 'post',
                url: '/cart/ajax/remove',
                data: {
                    rowId: rowId
                }
            }).then(res => {
                if (res.data.error == 0) {
                    setTimeout(function() {
                        $('#CartCount').html(res.data.count_cart);
                        $('#header-cart .total .money').html(res.data.total);
                    }, 1000);
                    alertJs('success', res.data.msg);
                } else {
                    alertJs('error', res.data.msg);
                }
            }).catch(e => console.log(e));
        });

        $(document).on('change', '.quantity1', function() {

            var qty = $(this).val(),
                rowId = $(this).data('rowid');

            if (qty > 0) {
                axios({
                    method: 'post',
                    url: '{{ route('carts.update') }}',
                    data: {
                        rowId: rowId,
                        qty: qty
                    }
                }).then(res => {
                    if (res.data.error == 0) {
                        // $('.carts-content').html(res.data.view);

                        // Update cart table
                        $('.carts-content .cart-table-include').html(res.data.view);

                        // Update header cart
                        setTimeout(function() {
                            $('#CartCount').html(res.data.count_cart);
                            $('.site-cart #header-cart').remove();
                            $('.site-cart').append(res.data.view_cart_mini);
                            $(".site-cart").find("#header-cart").addClass("d-block");

                            let subtotal = res.data.subtotal;

                            $('.into-money .ordertotal').html('$ ' + number_format(subtotal, 2, '.', ','));

                            setTimeout(function() {
                                $(".site-cart").find("#header-cart").removeClass("d-block");
                            }, 1000);

                        }, 1000);

                        alertJs('success', res.data.msg);

                    } else {
                        alertJs('error', res.data.msg);
                    }
                }).catch(e => console.log(e));
            }
        })
    </script>
@endpush
