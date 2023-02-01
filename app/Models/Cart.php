<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'cart_product', 'cart_id', 'product_id')->withPivot('amount', 'size_id');
    }

    public function productSizes()
    {
        return $this->belongsToMany(ProductSize::class, 'cart_product_size', 'cart_id', 'product_size_id')->withPivot('amount');
    }

    public function cartsProduct()
    {
        return$this->hasMany(CartProduct::class, 'cart_id');
    }
}
