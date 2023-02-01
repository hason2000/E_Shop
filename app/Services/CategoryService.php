<?php

namespace App\Services;

use App\Repositories\Category\CategoryRepositoryInterface;

class CategoryService
{
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
}