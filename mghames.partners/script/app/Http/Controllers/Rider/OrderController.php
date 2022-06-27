<?php

namespace App\Http\Controllers\Rider;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Ordershipping;
use Illuminate\Http\Request;
use Auth;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders_counts = Ordershipping::where('user_id',Auth::User()->id)->count();
        $complete_orders = Ordershipping::where('user_id',Auth::User()->id)->where('status_id',1)->count();
        $pending_orders = Ordershipping::where('user_id',Auth::User()->id)->where('status_id',3)->count();
        $cancelled_orders = Ordershipping::where('user_id',Auth::User()->id)->where('status_id',2)->count();

        if($request->start_date && $request->end_date)
        {
            $start_date = Carbon::parse($request->start_date)->format('Y-m-d h:i:s');
            $end_date = Carbon::parse($request->end_date)->format('Y-m-d h:i:s');

            $orders = Ordershipping::whereHas('order', function ($query) use ($start_date,$end_date)
            {
                 $query->whereBetween('created_at', [$start_date,$end_date]);
            })->with('order')->where('user_id',Auth::User()->id)->orderBy('id','DESC')->paginate(20);
            

            $start = $request->start_date;
            $end = $request->end_date;
    
           
        }elseif($request->status)
        {
            $request_status = $request->status;
            $orders = Ordershipping::whereHas('order', function ($query) use ($request_status)
            {
                 $query->where('status_id',$request_status);
            })->with('order')->where('user_id',Auth::User()->id)->orderBy('id','DESC')->paginate(20);
           
    
           
        }elseif($request->search)
        {
            $search = $request->search;
            $orders = Ordershipping::whereHas('order', function ($query) use ($search)
            {
                 $query->where('invoice_no','like', '%' . $search . '%');
            })->with('order')->where('user_id',Auth::User()->id)->orderBy('id','DESC')->paginate(20);
            
    
           
        }
        else
        {
            $orders = Ordershipping::whereHas('order')->with('order')->where('user_id',Auth::User()->id)->orderBy('id','DESC')->paginate(20);
           
        }

         return view('rider.order.index',compact('orders','orders_counts','complete_orders','pending_orders','cancelled_orders','request'));
    }

    public function show($id)
    {
        $info=Order::with('orderstatus','orderitems','getway','user','shippingwithinfo','ordermeta','getway','schedule','ordertable')->whereHas('shipping',function($q){
            return $q->where('user_id',Auth::id());
        })->findorFail($id);
        $ordermeta=json_decode($info->ordermeta->value ?? '');
        $order_status=Category::where([['type','status'],['status',1]])->orderBy('featured','ASC')->get();
        if ($info->order_method == 'delivery') {
           $riders=User::where('role_id',5)->latest()->get();
        }
        else{
            $riders=[];
        }
        return view('rider.order.show',compact('info','ordermeta','order_status','riders'));
    }

    public function delivered(Request $request)
    {
        
        $ordershipping = Ordershipping::where('user_id',Auth::id())->findOrFail($request->shipping_id);
        $order= Order::findOrFail($request->order_id);
        if ($order->user_id != null) {
            $validated = $request->validate([
                'otp' => 'required',
            ]);

            if($ordershipping->tracking_no == $request->otp)
            {

                $order->status_id = 1;

                if ($request->payment_status) {
                    $order->payment_status = $request->payment_status;
                }

                $order->save();
                

                $ordershipping->status_id=1;
                $ordershipping->save();

                return response()->json('Order Delivery Completed.');
            }else{
                $errors['errors']['error']='The OTP number is invalid.';
                return response()->json($errors,401);
            }
        }
        else{
            $order->status_id = 1;
            if ($request->payment_status) {
                $order->payment_status = $request->payment_status;
            }
            $order->save();

            $ordershipping->status_id=1;
            $ordershipping->save();

            return response()->json('Order Delivery Completed.');
        }



    }

    public function cancelled($id)
    {
        $order = Order::whereHas('shipping',function($q){
            return $q->where('user_id',Auth::id());
        })->findOrFail($id);
        $order->status_id = 2;
        $order->save();

        $order->shipping()->update(['status_id'=>2]);


        return back();
    }
}
