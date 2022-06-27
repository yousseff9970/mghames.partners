<?php

namespace App\Http\Controllers;

use App\Terms;
use Carbon\Carbon;
use App\Models\Plan;
use App\Models\User;
use App\Models\Order;
use App\Models\Option;
use App\Models\Tenant;
use App\Jobs\SendEmailJob;
use Illuminate\Http\Request;
use App\Mail\OrderMailExpired;
use App\Mail\Planrenew;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use DB;
use Str;
use Http;

class CronController extends Controller
{
    public function alertUserAfterExpiredOrder(){
         
         $tenants=Tenant::where('will_expire','<=' ,Carbon::today())->where('auto_renew',0)->where('status',1)->with('orderwithplan','user')->get();
         Order::where('will_expire','<=' ,Carbon::today())->where('status',1)->update(array('status' => 3)); //expired
         Tenant::where('will_expire','<=' ,Carbon::today())->where('auto_renew',0)->where('status',1)->update(array('status' => 3));

         $option = Option::where('key','cron_option')->first();
         $cron_option = json_decode($option->value);

         $trial_tenants=[];
         $expireable_tenants=[];
        foreach($tenants as $row){
            $plan=$row->orderwithplan->plan;
            
            if (!empty($plan)) {
                if($row->orderwithplan->plan->is_trial == 1){
                   $order_info['email']=$row->user->email;
                   $order_info['name']=$row->user->name;
                   $order_info['plan_name']=$plan->name;
                   $order_info['tenant_id']=$row->id;
                   $order_info['will_expire']=$row->will_expire;
                   array_push($trial_tenants, $order_info);
                  
               }
               else{

                   $order_info['email']=$row->user->email;
                   $order_info['name']=$row->user->name;
                   $order_info['plan_name']=$plan->name;
                   $order_info['tenant_id']=$row->id;
                   $order_info['will_expire']=$row->will_expire;
                   $order_info['amount']=$plan->price;
                   $order_info['plan_name']=$plan->name;
                   array_push($expireable_tenants, $order_info);
               }
            }
         }

         $this->expiredTenant($trial_tenants,$cron_option->trial_expired_message);
         $this->expiredTenant($expireable_tenants,$cron_option->expire_message);
         
 
         return "success";
     }


     //send notification for the free trial expired tenant owner
     public function expiredTrialTenant($data,$massege)
     {
          foreach($data ?? []  as $row){
                
                $references['Store name']=$row['tenant_id']; 
                $references['Date of expire']=$row['will_expire'];
                 
                $maildata=[
                    'type'=>'auto_payment',
                    'subject'=>'['.strtoupper(env('APP_NAME')).'] - Subscription Free Trial End ',
                    'message'=>$message,
                    'references'=>json_encode($references),
                    'name'=>$row['name'],
                    'email'=>$row['email'],
                ];

             if (env('QUEUE_MAIL') == 'on') {
                 dispatch(new SendEmailJob($maildata));
             }else{

                 Mail::to($row['email'])->send(new Planrenew($maildata)); 
             } 
        }
     }


     //send notification for the expired tenant owner
     public function expiredTenant($data,$massege)
     {
         foreach($data ?? []  as $row){
                
                $references['Store name']=$row['tenant_id']; 
                $references['Plan name']=$row['plan_name'];
                $references['Date of expire']=$row['will_expire'];
                 
                $maildata=[
                    'type'=>'auto_payment',
                    'subject'=>'['.strtoupper(env('APP_NAME')).'] - Subscription Expired For '.$row['tenant_id'],
                    'message'=>$message,
                    'references'=>json_encode($references),
                    'name'=>$row['name'],
                    'email'=>$row['email'],
                ];

             if (env('QUEUE_MAIL') == 'on') {
                 dispatch(new SendEmailJob($maildata));
             }else{

                 Mail::to($row['email'])->send(new Planrenew($maildata)); 
             } 
        }
     }
 

    //alert the tanant owner before expire the tenant
    public function alertUserBeforeExpiredOrder(){

         
         //before expired how many days left
          $option = Option::where('key','cron_option')->first();
         $cron_option = json_decode($option->value);

         $date= Carbon::now()->addDays($cron_option->days)->format('Y-m-d');
         
         $tenants=Tenant::where([['status',1],['will_expire','<=',$date],['auto_renew',0],['will_expire','!=',Carbon::now()->format('Y-m-d')]])->with('orderwithplan','user')->get();
         
        
         $expireable_tenants=[];

         foreach($tenants as $row){
            $plan=$row->orderwithplan->plan;
            
            if (!empty($plan)) {
                if($row->orderwithplan->plan->is_trial == 0){
                   $order_info['email']=$row->user->email;
                   $order_info['name']=$row->user->name;
                   $order_info['plan_name']=$plan->name;
                   $order_info['tenant_id']=$row->id;
                   $order_info['will_expire']=$row->will_expire;
                   $order_info['amount']=$plan->price;
                   $order_info['plan_name']=$plan->name;
                   array_push($expireable_tenants, $order_info);
                  
               }
               
            }
         }
         

         $this->expireSoon($expireable_tenants,$cron_option->alert_message);
        
         return "success";
    }


    //make automatic charge from the user credits
    public function makeCharge()
    {
        $order_completes=[];
        $balance_low_tenants=[];
        $plan_disabled_tenants=[];
        $failed_tenants=[];

        DB::beginTransaction();
         try {
         $tenants=Tenant::where([['status',1],['auto_renew',1],['will_expire','<=',date('Y-m-d')]])->with('orderwithplan','user')->get();
        $tax=Option::where('key','tax')->first()->value ?? 0;
        
        

        foreach($tenants as $row){
            $plan=$row->orderwithplan->plan;
            
            if (!empty($plan)) {
               
               if ($plan->is_trial == 0 && $plan->is_default == 0 && $row->orderwithplan->plan->status == 1) {
                 $price=$plan->price;
                 $duration=$plan->duration;
                 $plan_data=$plan->data;
                 
                 $total_amount=$price + (($price / 100) * $tax);
                 $tax_amount= ($price / 100) * $tax;

                 if ($row->user->amount >= $total_amount) {
                   
                    $user=User::find($row->user_id);
                    $user->amount=$row->user->amount-$total_amount;
                    $user->save();


                    $order=new Order;
                    
                    $order->user_id=$row->user_id;
                    $order->plan_id=$row->orderwithplan->plan->id;
                    $order->getway_id = 14;
                    $order->trx=$this->uniquetrx();
                    $order->is_auto=1;
                    $order->tax=$tax_amount;
                    $order->will_expire=Carbon::now()->addDays($duration);
                    $order->price=$total_amount;
                    $order->status=1;
                    $order->payment_status=1;
                    $order->save();
                    DB::table('tenants')
                    ->where('id', $row->id)
                    ->update([
                        'order_id' => $order->id,
                        'plan_info' => $plan_data,
                        'will_expire' => Carbon::now()->addDays($duration),
                    ]);
                    $order_info['email']=$row->user->email;
                    $order_info['name']=$row->user->name;
                    $order_info['amount']=$total_amount;
                    $order_info['plan_name']=$plan->name;
                    $order_info['tenant_id']=$row->id;
                    $order_info['trx']=$order->trx;
                    $order_info['invoice_no']=$order->invoice_no;

                    $domain= new \App\Models\Tenantorder;
                    $domain->tenant_id=$row->id;
                    $domain->order_id=$order->id;
                    $domain->save();

                    array_push($order_completes, $order_info);
                 }
                 else{
                    $order_info['email']=$row->user->email;
                    $order_info['name']=$row->user->name;
                    $order_info['amount']=$total_amount;
                    $order_info['plan_name']=$plan->name;
                    $order_info['tenant_id']=$row->id;
                    array_push($balance_low_tenants, $order_info);
                    array_push($failed_tenants, $row->id);
                 }

               }
               elseif($row->orderwithplan->plan->status == 0){
                   $order_info['email']=$row->user->email;
                   $order_info['name']=$row->user->name;
                   $order_info['plan_name']=$plan->name;
                   $order_info['tenant_id']=$row->id;
                   array_push($plan_disabled_tenants, $order_info);
                   array_push($failed_tenants, $row->id);
                  
               }

            }
            

        }
        DB::commit();
         } catch (\Throwable $th) {
        DB::rollback();

        }

        Tenant::whereIn('id',$failed_tenants)->update(array('status' => 3));

        $alert_msg= Option::where('key','automatic_renew_plan_mail')->first()->value;
        $alert_msg=json_decode($alert_msg);
        $this->OrderComplete($order_completes,$alert_msg->order_complete);
        $this->UserBalanceLow($balance_low_tenants,$alert_msg->user_balance_low);
        $this->PlanDisabled($plan_disabled_tenants,$alert_msg->plan_disabled);
        
        return "success";
    
    }

    //get unique trx id for order
    public function uniquetrx(){  
        $str = Str::random(40);
        $check = Order::where('trx', $str)->first();
        if($check == true){
            $str = $this->uniquetrx();
        }
        return $str;
    }


        
    //send notification mail before expire the order
    public function expireSoon($data,$message)
    {
        foreach($data ?? []  as $row){
                
                $references['Store name']=$row['tenant_id']; 
                $references['Plan name']=$row['plan_name'];
                $references['Last date of due']=$row['will_expire'];
                $references['Total amount']=number_format($row['amount'],2); 
                 
                $maildata=[
                    'type'=>'auto_payment',
                    'subject'=>'['.strtoupper(env('APP_NAME')).'] - Upcoming Subscription Renewal Notice',
                    'message'=>$message,
                    'references'=>json_encode($references),
                    'name'=>$row['name'],
                    'email'=>$row['email'],
                ];

             if (env('QUEUE_MAIL') == 'on') {
                 dispatch(new SendEmailJob($maildata));
             }else{

                 Mail::to($row['email'])->send(new Planrenew($maildata)); 
             } 
        }
    }


    //after successfully charge the automatic charge sent notification to the user
    public function OrderComplete($data,$message)
    {
        foreach($data ?? []  as $row){
                $references['Invoice No']=$row['invoice_no']; 
                $references['Plan name']=$row['plan_name']; 
                $references['Store name']=$row['tenant_id']; 
                $references['Total amount with tax']=number_format($row['amount'],2); 
                $references['Transaction Id']=$row['trx']; 
                $maildata=[
                    'type'=>'auto_payment',
                    'subject'=>'['.strtoupper(env('APP_NAME')).'] - Confirmation of Receiving Payment',
                    'message'=>$message,
                    'references'=>json_encode($references),
                    'name'=>$row['name'],
                    'email'=>$row['email'],
                ];

             if (env('QUEUE_MAIL') == 'on') {
                 dispatch(new SendEmailJob($maildata));
             }else{

                 Mail::to($row['email'])->send(new Planrenew($maildata)); 
             } 
        }
    }


    //alert user if payment faild for balance low
    public function UserBalanceLow($data,$message)
    {
        foreach($data ?? []  as $row){
                $references['Plan name']=$row['plan_name']; 
                $references['Store name']=$row['tenant_id']; 
                $references['Total amount with tax']=number_format($row['amount'],2); 

                $maildata=[
                    'type'=>'auto_payment',
                    'subject'=>'['.strtoupper(env('APP_NAME')).'] - Subscription renewal failed for '.$row['tenant_id'],
                    'message'=>$message,
                    'references'=>json_encode($references),
                    'name'=>$row['name'],
                    'email'=>$row['email'],
                    'references'=>json_encode($references),
                ];

             if (env('QUEUE_MAIL') == 'on') {
                 dispatch(new SendEmailJob($maildata));
             }else{

                 Mail::to($row['email'])->send(new Planrenew($maildata)); 
             } 
        }
    }


    //alert the owner if the plan is disabled
    public function PlanDisabled($data,$message)
    {
        foreach($data ?? []  as $row){
                $references['Plan name']=$row['plan_name']; 
                $references['Store name']=$row['tenant_id']; 
               
                $maildata=[
                    'type'=>'auto_payment',
                    'subject'=>'['.strtoupper(env('APP_NAME')).'] - Subscription renewal failed for '.$row['tenant_id'],
                    'message'=>$message,
                    'references'=>json_encode($references),
                    'name'=>$row['name'],
                    'email'=>$row['email'],
                    'references'=>json_encode($references),
                ];

             if (env('QUEUE_MAIL') == 'on') {
                 dispatch(new SendEmailJob($maildata));
             }else{

                 Mail::to($row['email'])->send(new Planrenew($maildata)); 
             } 
        }
    }

    public function tenantPricereset()
    {
      $tenants= Tenant::where([['status',1],['will_expire','>=',Carbon::today()]])->get();

       foreach ($tenants as $key => $value) {
       
          if (!empty($value->tenancy_db_name)) {
            try {
                echo Http::accept('application/json')->get(env('APP_URL').'/api/store/'.$value->id.'/cron/product-price-reset');
            } catch (Exception $e) {
                
            }
             
          }
       }
    }
}
