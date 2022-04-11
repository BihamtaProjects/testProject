<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Traits\hasPermissionTrait;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, hasPermissionTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'mobile_number',
        'password',
        'picture'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'mobile_number_verified_at' => 'datetime'
    ];
    public function roles() {

        return $this->belongsToMany(Role::class);

    }
    public function favorites() {

        return $this->belongsToMany(covent::class,'user_favorite');

    }
    public function permissions() {

        return $this->belongsToMany(Permission::class);

    }
    public function instructor()
    {
        return $this->hasOne(Instructor::class);
    }

    public function Comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
