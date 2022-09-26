<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request){
        $category = ProductCategory::count();
        $products = Product::count();
        $orders = Order::count();
        $users = User::count();
        return view('admin/dashboard',['category'=>$category,'products'=>$products,'orders'=>$orders,'users'=>$users]);
    }
}
