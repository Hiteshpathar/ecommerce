<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'address1',
        'address2',
        'city',
        'postal_code',
        'telephone',
        'mobile',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
