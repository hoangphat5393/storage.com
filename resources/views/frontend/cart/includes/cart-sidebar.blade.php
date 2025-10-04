@php
    $subtotal = 0;
    $auth_discount = 0;
    foreach ($carts as $cart) {
        $price = 0;
        $product = $ProductModel::find($cart->id);
        $price = $product->price;
        $subtotal += $price;
    }
    // $total = Cart::total(2);

    // if (auth()->check()) {
    //     $auth_discount = ($subtotal * setting_cost('auth_discount')) / 100;
    // }
@endphp
<div class="col-12 col-lg-4 pt-sm-4 pt-md-3">
    <div class="cart-total bdr ">
        <div class="heading">Tổng đơn hàng</div>
        <div class="body">
            <div class="mb-3 into-money">
                <div class="d-flex justify-content-between">
                    <div class="subtotal text-uppercase">Tổng giá:</div>
                    <div class="subtotal ordertotal">
                        {!! render_price(Cart::total(2), 'VND') !!}
                    </div>
                </div>
            </div>

            {{-- <button class="btn btn-success btn-checkout d-block w-100 mt-3 submit-confirm" type="button">
                <i class="fa-regular fa-cart-shopping"></i> CHECKOUT
            </button> --}}
        </div>
    </div>
</div>
