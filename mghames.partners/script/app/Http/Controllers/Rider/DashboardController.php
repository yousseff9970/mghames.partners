<?php

namespace App\Http\Controllers\Rider;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Ordershipping;
use Illuminate\Http\Request;
use Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $total_orders = Ordershipping::where('user_id',Auth::User()->id)->count();
        $approve_orders = Ordershipping::whereHas('order')->where('status_id',1)->where('user_id',Auth::User()->id)->count();
        $failed_orders = Ordershipping::whereHas('order')->where('status_id',2)->where('user_id',Auth::User()->id)->count();

        $orders = Ordershipping::where('user_id',Auth::User()->id)->paginate(20);

        return view('rider.dashboard',compact('total_orders','approve_orders','failed_orders','orders'));
    }

    public function live_orders()
    {
        $orders = Ordershipping::where('status_id',3)->whereHas('orderdata')->with('orderdata')->where('user_id',Auth::User()->id)->take(10)->orderBy('id', 'DESC')->get()->map(function($q){
            $data['id']=$q->id;
            $data['invoice_no']=$q->orderdata->invoice_no;
            $data['total']=number_format($q->orderdata->total,2);
            $data['order_id']=$q->order_id;
            $data['created_at']=$q->orderdata->created_at->diffForhumans();

            return $data;

        });

        return response()->json($orders);
    }
}
