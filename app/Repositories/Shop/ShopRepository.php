<?php

namespace App\Repositories\Shop;

use App\Models\Shop;
use App\Repositories\AbstractRepository;

class ShopRepository extends AbstractRepository implements ShopRepositoryInterface
{
    public function __construct(Shop $model)
    {
        $this->model = $model;
    }

    public function getShopByProduct($product)
    {
        return $product->shop;
    }

    public function checkShopExist($shopId)
    {
        $shop = Shop::where('id', $shopId)->exists();
        return $shop;
    }
}