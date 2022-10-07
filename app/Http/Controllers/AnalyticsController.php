<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $date = Carbon::createFromDate(2017, 2, 23);
        $startDate = $request->params['startDate']??$date->copy()->startOfYear();
        $endDate = $request->params['endDate']??$date->copy()->endOfYear();

        $total_sales = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('sum(total_amount) as total_sales')
)->whereBetween(DB::raw('date(created_at)'), [$startDate,$endDate])
            ->groupBy('month')
            ->get()
            ->toArray();

        $sales = [];
        $total = 0;
        foreach ($total_sales as $key => $data){
            $sales[$key] = $data['total_sales'];
            $total += $data['total_sales'];
        }
        $info['sales'] = $sales;
        $info['total'] = $total;
        return $info;
    }
}
