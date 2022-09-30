<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request){
        $category = ProductCategory::count();
        $products = Product::count();
        $orders = Order::count();
        $users = User::count();
        $month = ['January', 'February', 'March', 'April', 'May', 'June','July','August','September','October','November','December'];

        $graph_orders = [];
        foreach ($month as $key => $value) {
            $graph_orders[] = Order::where(DB::raw("DATE_FORMAT(created_at, '%M')"), $value)->count();
        }

        return view('admin/dashboard',[
            'category'=>$category,
            'products'=>$products,
            'orders'=>$orders,
            'users'=>$users,
            'month'=>json_encode($month, JSON_NUMERIC_CHECK),
            'graph_orders'=>json_encode($graph_orders, JSON_NUMERIC_CHECK),
        ]);
    }
}
