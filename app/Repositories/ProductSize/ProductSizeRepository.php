<?php

namespace App\Repositories\ProductSize;

use App\Models\ProductSize;
use App\Repositories\AbstractRepository;
use Illuminate\Support\Facades\DB;

class ProductSizeRepository extends AbstractRepository implements ProductSizeRepositoryInterface
{
    public function __construct(ProductSize $model)
    {
        $this->model = $model;
    }

    public function getAllOfProductId($productId)
    {
        return ProductSize::where('product_id', $productId)->get();
    }

    public function getByProductAndSize($productId, $sizeId)
    {
        return ProductSize::where('product_id', $productId)->where('size_id', $sizeId)->first();
    }

    public function getSizesOfProductInCartUser($productId, $cartId)
    {
        $dataGet = DB::table('cart_product_size')->select('product_size_id', 'amount')->where('cart_id', '=', $cartId)->get()->toArray();
        $sizeInCartArray = array();
        foreach ($dataGet as $data) {
            $sizeId = $this->show($data->product_size_id)->size_id;
            $sizeInCartArray[$sizeId] = $data->amount;
        }
        return $sizeInCartArray;
    }

    public function getAmoutOfProductSizeInCart($productSizeId, $cartId)
    {
        $data = DB::table('cart_product_size')->where('product_size_id', $productSizeId)->where('cart_id', $cartId)->first();
        return is_null($data) ? 0 : $data->amount;
    }

    public function getAmountProductUnorderOfCart($cart)
    {
        return $cart->productSizes()->count();
    }
}
