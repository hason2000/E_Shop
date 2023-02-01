<?php

namespace App\Repositories\Address;

use App\Models\Address;
use App\Repositories\AbstractRepository;

class AddressRepository extends AbstractRepository implements AddressRepositoryInterface
{
    public function __construct(Address $model)
    {
        $this->model = $model;
    }

    public function getAddressesByUser($user)
    {
        return $user->addresses;
    }
}