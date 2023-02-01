@extends('admin.layouts.app')

@section('content')
    <div class="right_col">
        <div class="row">
            <input type="text" class="form-control" placeholder="key" name="key-name" id="key-name-search"
                   data-link="{{ route('admin.product.out_stock') }}">
            <div id="contentproductadmin" class="tab-pane fade in active">
                @include('admin.products.product-outstock')
            </div>
        </div>
    </div>
@endsection
