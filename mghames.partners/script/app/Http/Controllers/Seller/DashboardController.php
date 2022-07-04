<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Media;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Term;
use App\Models\Category;
use App\Models\User;
use Auth;
class DashboardController extends Controller
{
    public function dashboard()
    {
        abort_if(!getpermission('dashboard'),401);
    	return view('seller.dashboard');
    }

    public function getCurrentOrders()
    {
        $today=Carbon::today();
        $orders=Order::where('status_id',3)
                ->whereDate('created_at', $today)
                ->latest()
                ->with('orderstatus')
                ->get()->map(function($query){

                    $data['orderid']=$query->invoice_no;
                    $data['url']=route('seller.order.show',$query->id);
                    $data['id']=$query->id;
                    $data['amount']=number_format($query->total,2);
                    $data['time']=$query->created_at->diffForhumans();
                    $data['status']=$query->orderstatus->name ?? 'Pending';
                    $data['status_color']=$query->orderstatus->slug ?? '#FFFF00';

                    return $data;
                });

        return response()->json(['orders'=>$orders]);
    }

   public function cacheClear(){
     $info=Tenant();
     if (env('CACHE_DRIVER') == 'memcached' || env('CACHE_DRIVER') == 'redis') {
          \Config::set('app.env', 'local');
          \Artisan::call('cache:clear --tags='.tenant('id'));
     }
     $info->cache_version=rand(10,20);
     $info->save();

     return response()->json('Store cache cleared');
   }

     public function order_statics($month)
    {
        $month=Carbon::parse($month)->month;
        $year=Carbon::parse(date('Y'))->year;
        

        $total_orders=Order::whereMonth('created_at', '=',$month)->whereYear('created_at', '=',$year)->count();
        $total_pending=Order::whereMonth('created_at', '=',$month)->whereYear('created_at', '=',$year)->where('status_id',3)->count();
        $total_completed=Order::whereMonth('created_at', '=',$month)->whereYear('created_at', '=',$year)->where('status_id',1)->count();
        $total_processing=Order::whereMonth('created_at', '=',$month)->whereYear('created_at', '=',$year)->where([['status_id','!=',1],['status_id','!=',2]])->count();
       
        
        
        $data['total_orders']=number_format($total_orders);
        $data['total_pending']=number_format($total_pending);
        $data['total_completed']=number_format($total_completed);
        $data['total_processing']=number_format($total_processing);

        return response()->json($data);
    }

    public function subscriptionStatus()
    {
         //$info=Tenant::findorFail($id);
         $plan=new \App\Models\Plan;
         $features=$plan->plandata;

         foreach($features as $key => $value){
            if ($key=='storage_limit') {
                if ((int)tenant($key) == -1) {
                    $data[ucfirst(str_replace('_',' ',$key))]='Unlimited';
                }
                else{
                    $data[ucfirst(str_replace('_',' ',$key))]=number_format(tenant($key),2).' - '.number_format(Media::sum('size'),2).'MB';
                }
                
            }
            elseif($key=='post_limit'){
                if ((int)tenant($key) == -1) {
                    $data[ucfirst(str_replace('_',' ',$key))]='Unlimited';
                }
                else{
                    $data[ucfirst(str_replace('_',' ',$key))]=tenant($key).' - '.Term::count()+Category::count();
                }
            }

            elseif($key=='staff_limit'){
                if ((int)tenant($key) == -1) {
                    $data[$key]='Unlimited';
                }
                else{
                    $admins=User::where('role_id',3)->count();
                    $riders=User::where('role_id',5)->count();
                    $data[ucfirst(str_replace('_',' ',$key))]=tenant($key).' - '.$admins+$riders;
                }
            }



            else{
                $data[ucfirst(str_replace('_',' ',$key))]=tenant($key) != null ? tenant($key) : '';
            }
            
         }

         return $data;
    }

    public function staticData()
    {
       
        $year=Carbon::parse(date('Y'))->year;
        $today=Carbon::today();


        $totalEarnings=Order::where('payment_status',1)->where('status_id',1)->whereYear('created_at', '=',$year)->sum('total');
        $totalEarnings=amount_format($totalEarnings);

        $totalSales=Order::where('status_id',1)->whereYear('created_at', '=',$year)->count();
        $totalSales=number_format($totalSales);
       

        $today_sale_amount = Order::where('status_id','!=',2)->whereDate('created_at', $today)->sum('total');
        $today_sale_amount=amount_format($today_sale_amount,'sign');

        $today_orders = Order::whereDate('created_at', $today)->count();
        $today_orders=number_format($today_orders);


        $yesterday_sale_amount = Order::where('status_id','!=',2)->whereDate('created_at', Carbon::yesterday())->sum('total');
        $yesterday_sale_amount=amount_format($yesterday_sale_amount,'sign');


        $previous_week = strtotime("-1 week +1 day");
        $start_week = strtotime("last sunday midnight",$previous_week);
        $end_week = strtotime("next saturday",$start_week);
        $start_week = date("Y-m-d",$start_week);
        $end_week = date("Y-m-d",$end_week);


        $lastweek_sale_amount = Order::where('status_id','=',1)->whereDate('created_at', '>', Carbon::now()->subDays(7))->sum('total');
        $lastweek_sale_amount=amount_format($lastweek_sale_amount,'sign');

        $lastmonth_sale_amount = Order::where('status_id','=',1)->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->sum('total');
        $lastmonth_sale_amount=amount_format($lastmonth_sale_amount,'sign');

        $thismonth_sale_amount = Order::where('status_id','=',1)->whereMonth('created_at', date('m'))
        ->whereYear('created_at', date('Y'))->sum('total');
        $thismonth_sale_amount=amount_format($thismonth_sale_amount,'sign');

        $orders=Order::whereYear('created_at', '=',$year)->orderBy('id', 'asc')->selectRaw('year(created_at) year, monthname(created_at) month, count(*) sales')
                ->groupBy('year', 'month')
                ->get();

        $earnings=Order::whereYear('created_at', '=',$year)->where('status_id',1)->orderBy('id', 'asc')->selectRaw('year(created_at) year, monthname(created_at) month, sum(total) total')
                ->groupBy('year', 'month')
                ->get();
        

        $current_pending_orders=Order::where('status_id',3)
                ->whereDate('created_at', $today)
                ->latest()
                ->with('orderstatus')
                ->get()->map(function($query){

                    $data['orderid']=$query->invoice_no;
                    $data['url']=route('seller.order.show',$query->id);
                    $data['id']=$query->id;
                    $data['amount']=number_format($query->total,2);
                    $data['time']=$query->created_at->diffForhumans();
                    $data['status']=$query->orderstatus->name ?? 'Pending';
                    $data['status_color']=$query->orderstatus->slug ?? '#FFFF00';

                    return $data;
                });
        $today_orders_list=Order::whereDate('created_at', $today)
                ->latest()
                ->with('orderstatus')
                ->get()->map(function($query){

                    $data['orderid']=$query->invoice_no;
                    $data['url']=route('seller.order.show',$query->id);
                    $data['id']=$query->id;
                    $data['amount']=number_format($query->total,2);
                    $data['time']=$query->created_at->diffForhumans();
                    $data['status']=$query->orderstatus->name ?? 'Pending';
                    $data['status_color']=$query->orderstatus->slug ?? '#FFFF00';

                    return $data;
                });
                
        
        $data['totalEarnings']=$totalEarnings;
        $data['totalSales']=$totalSales;
       
        $data['today_sale_amount']=$today_sale_amount;
        $data['today_orders']=$today_orders;
        $data['yesterday_sale_amount']=$yesterday_sale_amount;
        $data['lastweek_sale_amount']=$lastweek_sale_amount;
        $data['lastmonth_sale_amount']=$lastmonth_sale_amount;
        $data['thismonth_sale_amount']=$thismonth_sale_amount;
        $data['orders']=$orders;
        $data['current_pending_orders']=$current_pending_orders;
        $data['today_orders_list']=$today_orders_list;
        $data['earnings']=$earnings;
        $data['maxrated_products']=Term::with('preview')->whereHas('reviews')->withCount('reviews')->orderBy('reviews_count','DESC')->take(10)->get();
        $data['top_sell_products']=Term::with('preview')->whereHas('orders')->withCount('orders')->orderBy('orders_count','DESC')->take(10)->get();
        $data['top_customers']=User::whereHas('orders')->withCount('orders')->orderBy('orders_count','DESC')->take(10)->get()->map(function ($q){
            $userdata['id']=$q->id;
            $userdata['name']=$q->name;
            $userdata['orders_count']=$q->orders_count;

            return $userdata;
        });


        return response()->json($data);
    }

    public function perfomance($period)
    {
        

        if ($period != 365) {
            $earnings=Order::whereDate('created_at', '>', Carbon::now()->subDays($period))->where('status_id','!=',2)->orderBy('id', 'asc')->selectRaw('year(created_at) year, date(created_at) date, sum(total) total')->groupBy('year','date')->get();
        }
        else{
            $earnings=Order::whereDate('created_at', '>', Carbon::now()->subDays($period))->where('status_id','!=',2)->orderBy('id', 'asc')->selectRaw('year(created_at) year, monthname(created_at) month, sum(total) total')->groupBy('year','month')->get();
        }
       
        
        return response()->json($earnings);     
    }

    public function orderPerfomace($period)
    {
        
        $categories=Category::where('type','status')->select('id','name','type','slug')->get();

        $counters=[];

        foreach ($categories as $key => $value) {
            $data=[];
            
            $count= Order::whereDate('created_at', '>', Carbon::now()->subDays($period))->where('status_id',$value->id)->count();
            
            array_push($data,$value->name);
            array_push($data,$count);

            $counters=$data;
            array_push($counters,$data);

        }

        
        return response()->json($counters);     
    }



}
