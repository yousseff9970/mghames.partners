<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use File;
use App\Models\Option;
use Spatie\Analytics;
use Spatie\Analytics\Period;
use Carbon\Carbon;
class GoogleanalyticsController extends Controller
{
    public function index()
    {
        $info=get_option('googleanalytics',true);
        return view('seller.googleanalytics.index',compact('info'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ga_measurement_id' => 'required|max:20',
            'analytics_view_id' => 'required|max:20',
            'file' => 'mimes:json,text|max:100',
        ]);
        $data=Option::where('key','googleanalytics')->first();
        if (empty($data)) {
            $data=new Option;
            $data->key="googleanalytics";
        }

        $info['ga_measurement_id']=$request->ga_measurement_id;
        $info['analytics_view_id']=$request->analytics_view_id;

        $data->value=json_encode($info);
        $data->save();

        $path='uploads/'.tenant('uid');
        if ($request->hasFile('file')) {
            $file      = $request->file('file');
            $file->move($path, 'service-account-credentials.json');
        }

        return response()->json('Information Updated');
    }


    public function show($days)
    {
        return [];
        
        if (file_exists('uploads/'.tenant('uid').'/service-account-credentials.json')) {
            $info=get_option('googleanalytics',true);
            
            \Config::set('analytics.view_id', $info->analytics_view_id ?? '');
            \Config::set('analytics.service_account_credentials_json', 'uploads/'.tenant('uid').'/service-account-credentials.json');

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

    public function getCountries($period)
    {
        return $country = \Analytics::performQuery(Period::days($period),'ga:sessions',['dimensions'=>'ga:country','dimension'=>'ga:latitude','dimension'=>'ga:longitude','sort'=>'-ga:sessions']);
        
        $result= collect($country['rows'] ?? [])->map(function (array $dateRow) {
            return [
                'country' =>  $dateRow[0],
                'sessions' => (int) $dateRow[1],
            ];
        });
        
        return $result;
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
