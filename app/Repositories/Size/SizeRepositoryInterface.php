<?php

namespace App\Repositories\Size;

interface SizeRepositoryInterface
{
    public function getSizesByProduct($product);
}