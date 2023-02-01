<?php

namespace App\Repositories\Brand;

use App\Models\Brand;
use App\Repositories\AbstractRepository;

class BrandRepository extends AbstractRepository implements BrandRepositoryInterface
{
    public function __construct(Brand $model)
    {
        $this->model = $model;
    }

    public function getBrandByProduct($product)
    {
        return $product->brand;
    }

    public function checkBrandExist($brandId)
    {
        return Brand::where('id', $brandId)->exists();
    }
}
