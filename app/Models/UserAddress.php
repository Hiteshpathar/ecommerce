<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;
    protected $table = 'user_address';
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'mobile',
        'city',
        'state',
        'country',
        'postal_code',
        'address1',
        'address2',
        'is_primary'
    ];
}
