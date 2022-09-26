<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;
    public function inventory()
    {
        return $this->hasOne(ProductInventory::class,'id','inventory_id');
    }
    public function category()
    {
        return $this->hasOne(ProductCategory::class,'id','category_id');
    }
    public function orders()
    {
        return $this->hasmany(Order::class);
    }
    public function cart()
    {
        return $this->hasmany(Cart::class);
    }
    public function discount()
    {
        return $this->hasmany(Discount::class,'id','discount_id');
    }
    public function scopeFilter($query, $filters)
    {
        if (isset($filters['search'])) {
            $query->where('title', 'LIKE', '%' . $filters['search'] . '%');
        }
        if (isset($filters['status'])){
            $query->where('is_active',$filters['status']);
        }
    }
}
