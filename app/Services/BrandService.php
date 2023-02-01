<?php

namespace App\Services;

use App\Repositories\Brand\BrandRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class BrandService
{
    public function __construct(BrandRepositoryInterface $brandRepository, ProductRepositoryInterface $productRepository)
    {
        $this->brandRepository = $brandRepository;
        $this->productRespository = $productRepository;
    }

    public function getBrandsOfCategory(Collection $collection)
    {
        $brands = array();
        foreach ($collection as $key => $item) {
            $brands[$key] = $item->getBrands();
        }
        return $brands;
    }

    public function getBrandHome()
    {
        return $this->brandRepository->all()->count() > 7 ? $this->brandRepository->all()->take(7) : $this->brandRepository->all();
    }

    public function getBrandByIdProduct($id)
    {
        $product = $this->productRespository->show($id);
        return $this->brandRepository->getBrandByProduct($product);
    }
}
