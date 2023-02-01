@extends("user.layouts.checkout")

@section('content')
    <div style="min-height: 699px">
        <div class="container">
            <div class="row">
                <div class="cart-title">
                    <div class="cart-title-name col-sm-6">Products</div>
                    <div class="cart-title-name col-sm-1">Price</div>
                    <div class="cart-title-quantity col-sm-2">Quantity</div>
                    <div class="cart-title-total col-sm-2">Total</div>
                    <div class="cart-title-action col-sm-1">Action</div>
                </div>
            </div>
            @if(empty($items))
                <h2>No product in cart</h2>
            @else
                <form action="{{ route('cart.update', 1) }}" method="POST" id="form-cart-product">
                @csrf
                @method('PUT')
                @foreach($items as $key => $item)
                    <div class="row" style="margin-bottom: 20px">
                        <label for="product-size-3">
                            <div class="cart-item">
                                <div class="col-sm-1">
                                    <input type="checkbox" id="product-size-3" name="product-size[{{ $key }}]" value="{{ $item['amount'] }}">
                                </div>
                                <div class="col-sm-5">
                                    <div class="cart-item-product">
                                        <div class="cart-item-img">
                                            <img src="{{ $item['product_img'] }}">
                                        </div>
                                        <div class="cart-item-content">
                                            <div class="cart-item-name">{{ $item['product_name'] }}</div>
                                            <div class="cart-item-size">Size : {{ $item['size_name'] }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-1" style="display: flex">
                                    <div class="cart-item-price">
                                        {{ $item['product_price'] }}
                                    </div>
                                    <span>$</span>
                                </div>
                                <div class="col-sm-2">
                                    <div class="cart-item-quantity">
                                        <div class="input-group">
                                            @if ($item['max_amount'] ==  $item['amount'])
                                                <div class="input-group-btn">
                                                    <a class="btn btn-default btn-plus-product-cart disabled" style="opacity: 0.3">
                                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                                    </a>
                                                </div>
                                            @else
                                                <div class="input-group-btn">
                                                    <a class="btn btn-default btn-plus-product-cart" href="{{ route('cart.plus', [$cartId, $key]) }}">
                                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                                    </a>
                                                </div>
                                            @endif
                                            <input type="number" style="padding-left: 37px" class="form-control quantity-input-product-cart" value="{{ $item['amount'] }}" max="{{ $item['max_amount'] }}" data-link="{{ route('cart.change_quantity', [$cartId, $key]) }}">
                                            <div class="input-group-btn ">
                                                <a class="btn btn-default btn-minus-product-cart" href="{{route('cart.minus', [$cartId, $key])}}">
                                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2" style="display: flex">
                                    <div class="cart-item-total">
                                        {{ $item['product_price'] * $item['amount'] }}
                                    </div>
                                    <span>$</span>
                                </div>
                                <div class="col-sm-1 btn-delete-product-cart">
                                    <a href="{{ route('cart.delete_product', [$cartId, $key]) }}">Delete</a>
                                </div>
                            </div>
                        </label>
                    </div>
                @endforeach
                <div style="margin-bottom: 20px; text-align: right">
                    <button class="btn btn-submit-cart">Check Out</button>
                </div>
            </form>
            @endif
        </div>
    </div>
@endsection
