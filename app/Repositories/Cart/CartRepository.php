<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\ProductSize;
use App\Repositories\AbstractRepository;
use Illuminate\Support\Facades\DB;

class CartRepository extends AbstractRepository implements CartRepositoryInterface
{
    public function __construct(Cart $model)
    {
        $this->model = $model;
    }

    public function getCarts()
    {
        if ($this->model->count() > 100) {
            return $this->model->orderBy('id', 'desc')->take(100);
        }

        return $this->model->all();
    }
}
