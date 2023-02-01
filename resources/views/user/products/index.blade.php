@extends('user.layouts.app')

@section('content')
    <div class="container">
        <div class="row product-content">
            @include('user.layouts.tool')

            <div class="col-sm-9 product">
                <div>
                    <!--features_items-->
                    <h2 class="title text-center">PRODUCTS</h2>
                    @if (count($products) == 0)
                        <div class="result-search">No result product</div>
                    @else
                        @foreach ($products as $key => $product)
                            <div class="col-sm-4 product-view">
                                <a href="{{ route('products.show', $product['id']) }}">
                                    <div class="card item-product" style="background-color: white">
                                        <div>
                                            <img src="{{ $product['img_link'] }}" class="card-img-top" style="width: 100%; height: 195px">
                                        </div>
                                        <div class="card-body text-center">
                                            <h3 class="card-title text-center item-product-price">${{ $product['price'] }}</h3>
                                            <p class="card-text text-center">{{ $product['name'] }}</p>
                                        </div>
                                        <div class="d-flex justify-content-between item-product-tool">
                                            <a href=""><i class="fa fa-plus-square" aria-hidden="true"></i> Add to wish</a>
                                            <a href="{{ route('products.show', $product['id']) }}"><i class="fa fa-eye" aria-hidden="true"></i> View product</a>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @endif
                    {{ $products->links('user.layouts.pagination') }}
                </div>
            </div>
        </div>
    </div>
@endsection
