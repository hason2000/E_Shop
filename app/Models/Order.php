<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'cart_id',
        'status'
    ];

    public function cart()
    {
        $this->belongsTo(Cart::class, 'cart_id');
    }

    public function coupon()
    {
        $this->belongsToMany(Coupon::class, 'order_id', 'coupon_id');
    }
}
