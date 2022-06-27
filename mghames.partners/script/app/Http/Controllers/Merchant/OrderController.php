<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Auth;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        
        if($request->start_date && $request->end_date)
        {
            $start_data = Carbon::parse($request->start_date);
            $end_date = Carbon::parse($request->end_date);
            $orders = Order::whereBetween('created_at',[$start_data,$end_date])->where('user_id', Auth::id())->with('plan', 'getway')->latest()->paginate(25);
        }elseif($request->value)
        {
            $search = $request->value;
            
            $orders = Order::where([
                ['trx', 'LIKE', "%$search%"],
                ['user_id', Auth::id()]
            ])->with('plan', 'getway')->latest()->paginate(25);
        }
        else{
            $orders = Order::where('user_id', Auth::id())->with('plan', 'getway')->latest()->paginate(25);
        }
        return view('merchant.order.index',compact('orders'));
    }
}
