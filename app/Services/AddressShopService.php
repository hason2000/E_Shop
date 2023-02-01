<?php

namespace App\Services;


use App\Repositories\Address\AddressShopRepositoryInterface;

class AddressShopService
{
    public function __construct(AddressShopRepositoryInterface $addressShopRepository)
    {
        $this->addressShopRepository = $addressShopRepository;
    }

    public function getAddressByShop($shop)
    {
        return $shop->address;
    }
}