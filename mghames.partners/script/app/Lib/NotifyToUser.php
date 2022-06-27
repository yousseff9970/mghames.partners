<?php
namespace App\Lib;
use App\Models\Option;
use App\Models\Devicetoken;
use App\Jobs\Sellermailjob;
use Auth;
use App\Mail\Orderstatusmail;
use Mail;
use Config;
use App\Jobs\TenantMailJob;
class NotifyToUser 
{
	
	public static function makeNotifyToUser($info)
	{
		
		if($info->user_id != null){
			if ($info->notify_driver == 'mail') {
			 $ordermeta=json_decode($info->ordermeta->value ?? '');
			 if (!empty($ordermeta)) {
			 	$mail_to=$ordermeta->email ?? '';
			 }
			 else{
			 	$mail_to=$info->user->email ?? '';
			 }

			 $mail_from=Auth::user()->email;
			 NotifyToUser::customermail($info,$mail_to,$mail_from);
			}
			elseif($info->notify_driver == 'fmc'){
				$seo=get_option('seo',true);
				$token=Devicetoken::where('user_id',$info->user_id)->where('type','firebase')->latest()->first();

				if (!empty($token)) {
					NotifyToUser::fmc(ucwords($seo->title).' ('.$info->invoice_no.')','Your order is now in '.$info->orderstatus->name ?? '',url('/customer/order/'.$info->id),asset('uploads/'.tenant('uid').'/notification.png'),[$token->token]);
				}
				
			}
		}
		else{
			if ($info->notify_driver == 'mail') {
				$ordermeta=json_decode($info->ordermeta->value ?? '');
				if (!empty($ordermeta)) {
					$mail_to=$ordermeta->email ?? '';
				}
				else{
					$mail_to=$info->user->email ?? '';
				}

				$mail_from=Auth::user()->email;
				NotifyToUser::customermail($info,$mail_to,$mail_from);
			}
		}
		
		return true;
	}

	public static function makeNotifyToRider($info)
	{
		if (!empty($info->shippingwithinfo)) {

			if (!empty($info->shippingwithinfo->user_id)) {
				$token=Devicetoken::where('user_id',$info->shippingwithinfo->user_id)->where('type','firebase')->latest()->first();

				if (!empty($token)) {
					$seo=get_option('seo',true);

					$notify=NotifyToUser::fmc(ucwords($seo->title).' ('.$info->invoice_no.')','You\'ve been assigned a new order for delivery.',url('/rider/order/'.$info->id),asset('uploads/'.tenant('uid').'/notification.png'),[$token->token]);
					
				}
			}
		}
		
	}

	

	public static function customermail($info,$mail_to,$mail_from,$type='tenant_order_notification')
	{
		
		$data['to']=$mail_to;
		$data['from']=$mail_from;
		
		$data['type']=$type;
		
		if ($type == 'tenant_order_notification') {
			$currency=get_option('currency_info');
			$invoice_info=get_option('invoice_data',true);
			$data['currency_info']=$currency;
			$data['invoice_data']=$invoice_info;
			$data['data']=$info;
		}

		if ($type == 'order_recived') {
			$orderinfo['orderno']=$info->invoice_no;
			$orderinfo['tenantid']=tenant('id');
			$orderinfo['message']='You have received a new order';
			$orderinfo['link']=url('/seller/order',$info->id);
			$data['data']=$orderinfo;
			
		}
		
		
		if (env('QUEUE_MAIL') == 'on') {
			\Config::set('queue.connections', 'central');
			
		    dispatch(new TenantMailJob($data));
		}
		else{
			$mail = new Orderstatusmail($data);
		
            Mail::to($mail_to)->send($mail);
		}
		
		
	}


	public static function fmc($title,$description,$link,$icon,$user_tokens)
	{
		
        try {
        	
        	$data = [
        		"registration_ids" => $user_tokens,
        		"notification" => [
        			"title" => $title,
        			"body" => $description,
        			"icon" => $icon,
        			"click_action"=> $link

        		],

        	];


        	$dataString = json_encode($data);

        	$headers = [
        		'Authorization: key=' . env('FMC_SERVER_API_KEY'),
        		'Content-Type: application/json',
        	];

        	$ch = curl_init();

        	curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        	curl_setopt($ch, CURLOPT_POST, true);
        	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        	curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        	$response = curl_exec($ch);
        	
        	return true;

        } catch (Exception $e) {
        	return false;
        }


	}
}

?>