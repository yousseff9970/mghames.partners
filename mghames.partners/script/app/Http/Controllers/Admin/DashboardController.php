<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Domain;
use App\Models\Deposit;
use Spatie\Analytics;
use Spatie\Analytics\Period;

class DashboardController extends Controller
{
    

     public function staticData()
    {
        $total_subscribers=User::where('role_id',2)->count();
        $total_domain_request=Domain::where('status',2)->count();
        $total_earnings=Order::where('status','!=',0)->sum('price');
        $total_tax=Order::where('status','!=',0)->sum('tax');

       
        $year=Carbon::parse(date('Y'))->year;
        $today=Carbon::today();

        $earnings=Order::whereYear('created_at', '=',$year)
        		  ->where('status','!=',0)
        		  ->orderBy('id', 'ASC')
        		  ->selectRaw('year(created_at) year, monthname(created_at) month, sum(price) total')
        		  ->groupBy('year', 'month')->get()->map(function($q)
        		  {
        		  	 $data['year']=$q->year;
        		  	 $data['month']=$q->month;
        		  	 $data['total']=(float)number_format($q->total,2);

        		  	 return $data;
        		  });



        $total_earnings_this_year=Order::where('status','!=',0)
        						  ->whereYear('created_at', '=',$year)
        						  ->sum('price');


        $orders=Order::whereYear('created_at', '=',$year)
        		->orderBy('id', 'asc')->selectRaw('year(created_at) year, monthname(created_at) month, count(*) orders')
                ->groupBy('year', 'month')
                ->get();

        $total_order_this_year=Order::where('status','!=',0)->whereYear('created_at', '=',$year)->count();        

        $data['total_subscribers']=number_format($total_subscribers);
        $data['total_domain_request']=number_format($total_domain_request);
        $data['total_tax']=amount_admin_format($total_tax);
        $data['total_earnings']=amount_admin_format($total_earnings);
        $data['earnings']=$earnings;
        $data['total_earnings_this_year']=amount_admin_format($total_earnings_this_year);
        $data['orders']=$orders;
        $data['total_order_this_year']=number_format($total_order_this_year);

        return response()->json($data);

    }

    public function perfomance($period)
    {
        if ($period != 365) {
            $earnings=Order::whereDate('created_at', '>', Carbon::now()->subDays($period))->where('status','!=','canceled')->orderBy('id', 'asc')->selectRaw('year(created_at) year, date(created_at) date, sum(price) total')->groupBy('year','date')->get();
        }
        else{
            $earnings=Order::whereDate('created_at', '>', Carbon::now()->subDays($period))->where('status','!=','canceled')->orderBy('id', 'asc')->selectRaw('year(created_at) year, monthname(created_at) month, sum(price) total')->groupBy('year','month')->get();
        }
       
        
        return response()->json($earnings); 
    }

    public function depositPerfomance($period)
    {
        if ($period != 365) {
            $earnings=Deposit::whereDate('created_at', '>', Carbon::now()->subDays($period))->where('payment_status','!=',0)->orderBy('id', 'asc')->selectRaw('year(created_at) year, date(created_at) date, sum(amount) total')->groupBy('year','date')->get();
            
        }
        else{
            $earnings=Deposit::whereDate('created_at', '>', Carbon::now()->subDays($period))->where('payment_status','!=',0)->orderBy('id', 'asc')->selectRaw('year(created_at) year, monthname(created_at) month, sum(amount) total')->groupBy('year','month')->get();
        }
       
        
        return response()->json($earnings); 
    }

    public function order_statics($month)
    {
        $month=Carbon::parse($month)->month;
        $year=Carbon::parse(date('Y'))->year;

        $total_orders=Order::whereYear('created_at', '=',$year)->whereMonth('created_at', '=',$month)->count();

        $total_pending=Order::whereYear('created_at', '=',$year)->whereMonth('created_at', '=',$month)->where('status',2)->count();

        $total_completed=Order::whereYear('created_at', '=',$year)->whereMonth('created_at', '=',$month)->where('status',1)->count();

        $total_expired=Order::whereYear('created_at', '=',$year)->whereMonth('created_at', '=',$month)->where('status',3)->count();

        $data['total_orders']=number_format($total_orders);
        $data['total_pending']=number_format($total_pending);
        $data['total_completed']=number_format($total_completed);
        $data['total_processing']=number_format($total_expired);

        return response()->json($data);
    }


    public function google_analytics($days)
    {
        if (file_exists('uploads/service-account-credentials.json')) {
            // $info=google_analytics_for_user();
            
            // \Config::set('analytics.view_id', $info['view_id']);
            // \Config::set('analytics.service_account_credentials_json', $info['service_account_credentials_json']);
            $data['TotalVisitorsAndPageViews']=$this->fetchTotalVisitorsAndPageViews($days);
            $data['MostVisitedPages']=$this->fetchMostVisitedPages($days);
            $data['Referrers']=$this->fetchTopReferrers($days);
            $data['fetchUserTypes']=$this->fetchUserTypes($days);
            $data['TopBrowsers']=$this->fetchTopBrowsers($days);
        }
        else{
            $data['TotalVisitorsAndPageViews']=[];
            $data['MostVisitedPages']=[];
            $data['Referrers']=[];
            $data['fetchUserTypes']=[];
            $data['TopBrowsers']=[];
        }
                
        return response()->json($data);
    }


    public function fetchTotalVisitorsAndPageViews($period)
    {

        return \Analytics::fetchTotalVisitorsAndPageViews(Period::days($period))->map(function($data)
        {
            $row['date']=$data['date']->format('Y-m-d');
            $row['visitors']=$data['visitors'];
            $row['pageViews']=$data['pageViews'];
            return $row;
        });
        
    }
    public function fetchMostVisitedPages($period)
    {
        return \Analytics::fetchMostVisitedPages(Period::days($period));
        
    }

    public function fetchTopReferrers($period)
    {
        return \Analytics::fetchTopReferrers(Period::days($period));
        
    }

    public function fetchUserTypes($period)
    {
        return \Analytics::fetchUserTypes(Period::days($period));
        
    }

    public function fetchTopBrowsers($period)
    {
        return \Analytics::fetchTopBrowsers(Period::days($period));
        
    }
}
