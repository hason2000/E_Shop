<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shop extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'address_id',
        'name',
        'detail',
        'img_shop',
        'web_site'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'shop_id');
    }

    public function address()
    {
        return $this->belongsTo(AddressShop::class, 'address_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
