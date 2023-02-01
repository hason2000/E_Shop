<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSize extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product_size';
    protected $fillable = [
      'product_id',
      'size_id',
      'amount'
    ];

    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'cart_product_size', 'product_size_id', 'cart_id')->withPivot('amount');
    }
}
