<?php

namespace App\Services;

use App\Repositories\Address\AddressRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;

class AddressService
{
    public function __construct(AddressRepositoryInterface $addressRepository, UserRepositoryInterface $userRepository)
    {
        $this->addressRepository = $addressRepository;
        $this->userRepository = $userRepository;
    }

    public function getIdAddressByUser($userId)
    {
        $user = $this->userRepository->show($userId);
        return $this->getAddressesByUser($user)->pluck('id')->toArray();
    }

    public function getAddressesByUser($user)
    {
        return $this->addressRepository->getAddressesByUser($user);
    }
}
