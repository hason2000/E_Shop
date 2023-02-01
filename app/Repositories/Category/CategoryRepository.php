<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Repositories\AbstractRepository;

class CategoryRepository extends AbstractRepository implements CategoryRepositoryInterface
{
    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function checkCategoryExist($categoryId)
    {
        return Category::where('id', $categoryId)->exists();
    }
}
