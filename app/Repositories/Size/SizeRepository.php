<?php

namespace App\Repositories\Size;

use App\Models\Size;
use App\Repositories\AbstractRepository;

class SizeRepository extends AbstractRepository implements SizeRepositoryInterface
{
    public function __construct(Size $model)
    {
        $this->model = $model;
    }

    public function getSizesByProduct($product)
    {
        return $product->sizes;
    }

    public function getSizeByName($size)
    {
        return Size::where('name', $size)->get()[0];
    }

    public function checkSizesExist($data)
    {
        $sizes = Size::all()->pluck('id')->toArray();
        return array_keys($data) == $sizes;
    }
}
