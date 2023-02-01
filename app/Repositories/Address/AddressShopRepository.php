<?php

namespace App\Repositories\Address;

use App\Models\AddressShop;
use App\Repositories\AbstractRepository;

class AddressShopRepository extends AbstractRepository implements AddressShopRepositoryInterface
{
    public function __construct(AddressShop $model)
    {
        $this->model = $model;
    }

    public function getAddressByShop($shop)
    {
        return $shop->address;
    }
}
