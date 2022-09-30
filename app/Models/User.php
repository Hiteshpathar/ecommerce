<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'mobile',
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
    public function cart()
    {
        return $this->hasMany(Cart::class);
    }
    public function address()
    {
        return $this->hasMany(UserAddress::class,'user_id','id');
    }
    public function orders(){
        return $this->hasMany(Order::class,'user_id','id');
    }
    public function scopeFilter($query, $filters)
    {
        if (isset($filters['search'])) {
            $query->where('first_name', 'LIKE', '%' . $filters['search'] . '%');
            $query->orWhere('last_name', 'LIKE', '%' . $filters['search'] . '%');
            $query->orWhere('email', 'LIKE', '%' . $filters['search'] . '%');
        }
        if (isset($filters['status'])){
            $query->where('is_active',$filters['status']);
        }
    }
}
