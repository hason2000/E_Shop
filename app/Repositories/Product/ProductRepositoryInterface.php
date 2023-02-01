<?php

namespace App\Repositories\Product;

use Illuminate\Http\Request;

interface ProductRepositoryInterface
{
    public function getProduct(Request $request);

    public function getProductsByCart($cart);
}
