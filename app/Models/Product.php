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
}
