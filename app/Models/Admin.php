<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasFactory;
    use SoftDeletes, Notifiable, HasRoles;

    protected $fillable = [
        'username',
        'password',
        'email',
        'phone_number',
        'avatar',
        'role',
        'lock',
    ];

    protected $hidden = [
        'password'
    ];

    public function setPassWordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    // public function getUsernameAttribute()
    // {
    //     return ucfirst($this->attributes['username']);
    // }

    public function getAvatarAttribute()
    {
        return empty($this->attributes['avatar']) || is_null($this->attributes['avatar']) ? asset('images/home/avatar_default.jpg') : $this->attributes['avatar'];
    }
}
