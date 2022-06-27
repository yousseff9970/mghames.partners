<?php
namespace App\Lib;

use App\Models\Order;
use Session;
use Illuminate\Http\Request;
use Http;
use Str;
use Auth;
use App\Models\User;
class Credit {
        
    public static function redirect_if_payment_success()
    {
        return Session::has('fund_callback') ? Session::get('fund_callback')['success_url'] : url('partner/payment/success');
    }

    public static function redirect_if_payment_faild()
    {
        return Session::has('fund_callback') ? Session::get('fund_callback')['cancel_url'] : url('partner/payment/failed');
    }
   

    public static function make_payment($array)
    {
        
      
        $amount=$array['amount'];
        //$totalAmount=$array['pay_amount'];
        $name=$array['name'];
        $billName=$array['billName'];
        $test_mode=$array['test_mode'];
        $data['payment_mode']='credit';
        $data['amount']=$amount;
        $data['test_mode']=$test_mode;
        $data['charge']=$array['charge'];
        $data['main_amount']=$array['pay_amount'];
        $data['getway_id']=$array['getway_id'];
        $data['payment_type']=$array['payment_type'];
        return Credit::status($data);
    }


    public static function status($info)
    {
        
        
        $user=User::findorFail(Auth::id());
        if ($user->amount >= $info['main_amount']) {
            $user->amount=$user->amount-$info['main_amount'];
            $user->save();
            $data['payment_id'] = Credit::generateString();           
            $data['payment_method'] = "credit";
            $data['getway_id'] = $info['getway_id'];
            $data['payment_type'] = $info['payment_type'];
            $data['amount'] = $info['main_amount'];
            $data['charge'] = $info['charge'];
            $data['status'] = 1;   
            $data['payment_status'] = 1;  
        }
        else{
            $data['status'] = 0;   
            $data['payment_status'] = 0; 
        }

       
        
       
        Session::put('payment_info',$data); 
        if ($data['status'] == 1) {
            return redirect(Credit::redirect_if_payment_success());
        }
        return redirect(Credit::redirect_if_payment_faild());
      
    }


    public static function generateString()
    {
        $str = Str::random(10);
        $payment = Order::where('trx',$str)->count();
        if ($payment == 0) {
            return $str;
        }
        return $this->generateString();
    }

}


?>
