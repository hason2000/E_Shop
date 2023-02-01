<?php

namespace App\Repositories\Shop;

interface ShopRepositoryInterface
{
    public function getShopByProduct($product);
}