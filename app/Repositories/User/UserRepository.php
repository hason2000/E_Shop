<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\AbstractRepository;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getUsersReviewByProduct($product)
    {
        return $product->reviews;
    }

    public function getUserUnConfirm($id)
    {
        return User::where('id', $id)->where('status_register', '0');
    }

    public function getEmailUserLock()
    {
        return User::where('lock', 1)->get()->pluck('email')->toArray();
    }

    public function getUserByShop($shop)
    {
        return $shop->user;
    }
}
