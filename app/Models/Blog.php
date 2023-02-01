<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'content'
    ];

    public function product()
    {
        $this->belongsTo(Product::class, 'product_id');
    }

    public function comments()
    {
        $this->hasMany(Comment::class, 'comment_id');
    }
}
