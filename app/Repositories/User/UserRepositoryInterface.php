<?php

namespace App\Repositories\User;

interface UserRepositoryInterface
{
    public function getUsersReviewByProduct($product);

    public function getUserUnConfirm($id);
}