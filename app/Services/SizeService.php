<?php

namespace App\Services;

use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\ProductSize\ProductSizeRepositoryInterface;
use App\Repositories\Size\SizeRepositoryInterface;

class SizeService
{
    public function __construct(SizeRepositoryInterface $sizeRepository, ProductRepositoryInterface $productRepository, ProductSizeRepositoryInterface $productSizeRepository)
    {
        $this->sizeRepository = $sizeRepository;
        $this->productRepository = $productRepository;
        $this->productSizeRepository = $productSizeRepository;
    }

    public function getSizesProduct($productId)
    {
        $product = $this->productRepository->show($productId);
        $sizes = $this->sizeRepository->getSizesByProduct($product);
        $sizesProduct = array();
        $sizesInCart = array();
        $cart = auth()->guard('web')->check() ? auth()->guard('web')->user()->cart : null;
        if (!is_null($cart)) {
            $sizesInCart = $this->productSizeRepository->getSizesOfProductInCartUser($productId, $cart->id);
        }
        foreach ($sizes as $size) {
            $sizesProduct[$size->name] = $size->pivot->amount;
            if (in_array($size->id, array_keys($sizesInCart))) {
                $sizesProduct[$size->name] = $sizesProduct[$size->name] - $sizesInCart[$size->id];
            }
        }
        return $sizesProduct;
    }
}
