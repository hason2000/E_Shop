<?php

namespace App\Services;

use App\Repositories\Img\ImgRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;

class ImgService
{
    public function __construct(ImgRepositoryInterface $imgRepository, ProductRepositoryInterface $productRepository)
    {
        $this->imgRepository = $imgRepository;
        $this->productRepository = $productRepository;
    }

    public function getImgsByIdProduct($id)
    {
        $product = $this->productRepository->show($id);
        $imgs = $this->imgRepository->getImgsByProduct($product)->toArray();
        return $imgs;
    }
}
