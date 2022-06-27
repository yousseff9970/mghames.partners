<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Price;
use App\Models\Discount;
use Schema;
use DB;
use Carbon\Carbon;
class CronController extends Controller
{
    public function ProductPriceReset()
    {
        $timezone=get_option('timezone');
        if (!empty($timezone)) {
           \Config::set('app.timezone', $timezone);
        }
        

        try {
        
        
         
            if (Schema::hasTable('prices')) {
               $discounts= Discount::where('ending_date','<=' ,Carbon::today())->whereHas('term')->get();
               $term_ids=[];
               foreach ($discounts ?? [] as $key => $row) {
                  array_push($term_ids,$row->term_id);
               }
               $prices=Price::where('old_price','!=',null)->whereIn('term_id',$term_ids)->get();
               DB::beginTransaction();
               try { 
                 foreach ($prices ?? [] as $key => $price) {
                  $price=Price::find($price->id);
                  if (!empty($price)) {
                   $price->price=$price->old_price;
                   $price->old_price=null;
                   $price->save();
                  }
                  
              }
              DB::commit();
              } catch (\Throwable $th) {
                DB::rollback();
               
             }  
             if (count($term_ids) != 0) {
                Discount::whereIn('term_id',$term_ids)->delete();
                return true;
             }
               
            }


        } catch (\Exception $e) {
         return false;
       }

       
    }
}
