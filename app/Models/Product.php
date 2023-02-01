<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'shop_id',
        'category_id',
        'brand_id',
        'name',
        'price',
        'condition',
        'detail',
        'img_link',

    ];

//    public function imgs()
//    {
//        return $this->hasMany(Img::class, 'product_id', 'id');
//    }
    public function images()
    {
        return $this->hasMany(Img::class, 'product_id', 'id');
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tag', 'product_id', 'tag_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function reviews()
    {
        return $this->belongsToMany(User::class, 'reviews', 'product_id', 'user_id')->withPivot('rating', 'content');
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_size', 'product_id', 'size_id')->withPivot('amount');
    }

    public function scopeFilter($query, $data)
    {
        if (isset($data['key_word']) && !is_null($data['key_word'])) {
            $query->where('name', 'LIKE', '%' . $data['key_word'] . '%');
        }

        if (isset($data['category_id']) && !is_null($data['category_id'])) {
            $query->where('category_id', $data['category_id']);
        }

        if (isset($data['brand_id']) && !is_null($data['brand_id'])) {
            $query->where('brand_id', $data['brand_id']);
        }

        if (isset($data['price_start']) && !is_null($data['price_start'])) {
            $query->where('price', '>=', $data['price_start']);
        }

        if (isset($data['price_finish']) && !is_null($data['price_finish'])) {
            $query->where('price', '<=', $data['price_finish']);
        }

        return $query;
    }

}
