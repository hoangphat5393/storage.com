<table class="table  table-hover  vcenter bdr">
    <thead>
        <tr>
            <th scope="col"></th>
            <th scope="col">Sản phẩm</th>
            <th scope="col" class="text-center">Số lượng</th>
            <th scope="col" class="text-center">Giá</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($carts as $cart)
            @php
                $price = 0;
                $product = $ProductModel::find($cart->id);
            @endphp

            @if (!empty($product))
                <tr class="cart-items cart__row_item">
                    <td class="cart-thumb">
                        @if (!empty($product->image))
                            <a class="flex-shrink-0" href="{{ route('product.detail', [$product->slug, $product->id]) }}" title="{{ $product->name }}">
                                <img class="img-fluid item-image d-block mx-auto" src="{{ get_image($product->image) }}" alt="{{ $product->name }}" width="70">
                            </a>
                        @endif
                    </td>
                    <td style="width: 250px">
                        <a class="flex-shrink-0 item-name" href="{{ route('product.detail', [$product->slug, $product->id]) }}" title="{{ $product->name }}">{{ $product->name }}</a>
                    </td>
                    <td>
                        <div class="mx-auto mx-sm-0 text-center text-sm-start" style="max-width: 9rem;">
                            {{-- <input data-rowid="{{ $cart->rowId }}" class="form-control form-control-sm cart__qty-input quantity1" type="number" name="updates[]" value="{{ $cart->qty }}" min="{{ $product->min_quantity }}" max="{{ $product->stock }}"> --}}
                            {{ $cart->qty }}
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="text-accent">{!! render_price($cart->price * $cart->qty, 'VND') !!}</div>
                    </td>

                    <td style="width: 80px">
                        <button class="btn btn-link w-100 cart__remove" type="button" data="{{ $cart->rowId }}">
                            <i class="fa-regular fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endif
        @endforeach
        <tr>
            <td colspan="6">
                <div class="d-flex justify-content-between">
                    <a href="{{ url()->previous() }}" class="btn btn-success btn-sm btn-table-cart" title="Continue shopping">
                        <i class="fas fa-arrow-left"></i>&nbsp; Tiếp tục mua hàng
                    </a>
                </div>
            </td>
        </tr>

    </tbody>
</table>
