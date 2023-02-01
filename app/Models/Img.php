<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Img extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'imgs';
    protected $fillable = [
        'product_id',
        'link'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
