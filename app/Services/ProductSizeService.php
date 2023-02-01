<?php

namespace App\Services;

use App\Repositories\ProductSize\ProductSizeRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;

class ProductSizeService
{
    public function __construct(ProductSizeRepositoryInterface $productSizeRepository, UserRepositoryInterface $userRepository)
    {
        $this->productSizeRepository = $productSizeRepository;
        $this->userRepository = $userRepository;
    }

    public function getAllOfProductId($id)
    {
        return $this->productSizeRepository->getAllOfProductId($id);
    }

    public function getAmountProductOfCart($userId)
    {
        $user = $this->userRepository->show($userId);
        $cart = $user->cart;
        !is_null($cart) ? $amount = $this->productSizeRepository->getAmountProductUnorderOfCart($cart) : $amount = 0;
        return $amount;
    }
}
