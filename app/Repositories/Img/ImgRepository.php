<?php

namespace App\Repositories\Img;

use App\Models\Img;
use App\Repositories\AbstractRepository;

class ImgRepository extends AbstractRepository implements ImgRepositoryInterface
{
    public function __construct(Img $model)
    {
        $this->model = $model;
    }

    public function getImgsByProduct($product)
    {
        return $product->imgs;
    }

    public function checkImgExist($id)
    {
        return Img::where('id', $id)->exists();
    }
}
