<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
//use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'date_of_birth',
        'money_account',
        'avatar',
        'address_default',
        'status_register',
        'lock'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPassWordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function getAvatarAttribute()
    {
        return is_null($this->attributes['avatar']) ? asset('images/home/avatar_default.jpg') : $this->attributes['avatar'];
    }

    public function getNameAttribute()
    {
        return strtoupper($this->attributes['name']);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'user_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'user_id');
    }

    public function wishLists()
    {
        return $this->belongsToMany(Product::class, 'wish_lists', 'user_id', 'product_id');
    }

    public function reviews()
    {
        return $this->belongsToMany(Product::class, 'reviews', 'user_id', 'product_id')->withPivot('rating', 'content');
    }

    public function shop()
    {
        return $this->hasOne(Shop::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
