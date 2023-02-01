<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'total_price'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function getBrands()
    {
        $products = $this->products;
        $brands = [];
        foreach ($products as $product) {
            $brands[] = $product->brand;
        }
        return array_unique($brands);
    }
}
