<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function scopeFilter($query, $filters)
    {
        if (isset($filters['search'])) {
            $search = $filters['search'];
            $query->where('total_amount', 'LIKE', '%' . $search . '%');
            $query->orWhere('quantity', 'LIKE', '%' . $search . '%');
            $query->orwhereHas('user', function ($innerQuery) use ($search) {
                $innerQuery->where('first_name', 'LIKE', '%' . $search . '%');
                $innerQuery->orWhere('last_name', 'LIKE', "%" . $search . "%");
            });
        }
    }

}
