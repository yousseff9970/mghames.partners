<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\Domain;
use App\Models\Option;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Mail\DomaintransferOtp;
use App\Jobs\SendEmailJob;
use Auth;
use Str;
use Http;
use Artisan;
use File;
use App\Models\Order;
use App\Models\Plan;
use Crypt;
use Storage;
class DomainController extends Controller
{

    public function index()
    {
    	$posts=Tenant::where('user_id',Auth::id())->with('orderwithplan')->latest()->paginate(50);
      abort_if(!getpermission('website_settings'),401);
        $file=file_get_contents('theme/themes.json');
        $themes = json_decode($file);

       
    	return view('merchant.domain.index',compact('posts'))->with('themes', $themes);
    }

    public function create()
    {
        if (Session::has('domain_data')) {
           Session::forget('domain_data');
        }
      return view('merchant.domain.create');
    }

    public function check(Request $request)
    {
        $request->validate([
            'domain' => 'required|max:20|unique:tenants,id|regex:/^\S*$/u', 
        ]);
      $store_name = Str::slug($request->domain);
      $store_name=str_replace('-','',$store_name);
      $tenant = Tenant::where('id',$store_name)->first();
      if($tenant)
      {
        return response()->json(['errors'=>'Store URL is unavailable']);
      }else{
        return response()->json('success');
      }
    }


    public function store(Request $request)
    {
      
        $request->validate([
           
            'email' => 'required|email',
            'password' => 'required|min:8|max:20|confirmed',
            'store_name' => 'required|max:20|unique:tenants,id|regex:/^\S*$/u', 
        ]);

        $name = Str::slug($request->store_name);

        $tenant = Tenant::where('id',$name)->first();

        if($tenant)
        {
          $error['errors']['domain']='Store URL is unavailable';
          return response()->json($error,422);
        }

        $data = [
          'store_name'=>$name,
          'email' => $request->email,
          'password' => $request->password,
          'db' => $request->db,
          
        ];


        Session::put('store_data',$data);
        ddd($data);

      return response()->json('Great! Now you need to select a plan.');

    }

    public function gateway()
    {
      
      $plans = Plan::where([['status', 1], ['is_default', 0]])->get();
      $orders = Order::where('user_id', Auth::id())->with('plan', 'getway')->latest()->paginate(25);
      return view('merchant.plan.index',compact('plans','orders'));
    }

    public function edit($id)
    {

    	$info=Tenant::where('user_id',Auth::id())->where('status',1)->findorFail($id);
      $obj=new Plan;
      $arr= $obj->plandata;
    	return view('merchant.domain.edit',compact('info','arr'));
    }

    public function domainConfig($id)
    {
        $info=Tenant::where('user_id',Auth::id())->with('subdomain','customdomain')->where('status',1)->findorFail($id);
        $plan= json_decode($info->plan_info ?? '');

        $dns=Option::where('key','dns_settings')->first();
        $dns=json_decode($dns->value ?? '');
        return view('merchant.domain.config',compact('info','plan','dns'));
    }

    public function update(Request $request,$id)
    {
      $validatedData = $request->validate([
        'name' => 'required|string|max:50',
      ]);
    	$check=Tenant::where([['id',Str::slug($request->name)],['id','!=',$id]])->where('status',1)->first();
    	if(!empty($check)){
    		$error['errors']['domain']='Store already exists';
    		return response()->json($error,422);
    	}

    	$info=Tenant::where('user_id',Auth::id())->findorFail($id);
    	$info->id=Str::slug($request->name);
      if ($request->auto_renew) {
        $info->auto_renew = 1;
      }
      else{
        $info->auto_renew = 0;
      }
    	$info->save();

    	return response()->json('Store Name Updated');
    }


    //add new subdomain
    public function addSubdomain(Request $request,$id)
    {
        $info=Tenant::where('user_id',Auth::id())->where('status',1)->findorFail($id);
        $check_before= Domain::where([['tenant_id',$id],['type',2]])->first();
        if (!empty($check_before)) {
            $error['errors']['domain']='Oops you already subdomain created....!!';
            return response()->json($error,422);
        }

       
        
            if ($info->sub_domain == 'on') {
                 $validatedData = $request->validate([
                    'subdomain' => 'required|string|max:50',
                 ]);

                 $domain=strtolower($request->subdomain).'.'.env('APP_PROTOCOLESS_URL');
                 $input = trim($domain, '/');
                 if (!preg_match('#^http(s)?://#', $input)) {
                    $input = 'http://' . $input;
                 }
                $urlParts = parse_url($input);
                $domain = preg_replace('/^www\./', '', $urlParts['host'] ?? $urlParts['path']);
                

                $check= Domain::where('domain',$domain)->first();
                if (!empty($check)) {
                    $error['errors']['domain']='Oops domain name already taken....!!';
                    return response()->json($error,422);
                }

                $subdomain= new Domain;
                $subdomain->domain= $domain;
                $subdomain->tenant_id= $id;
                if (env('AUTO_SUBDOMAIN_APPROVE') == true) {
                   $subdomain->status=1;
                }
                else{
                    $subdomain->status=2;
                }
                $subdomain->type=2;
                $subdomain->save();

                return response()->json('Subdomain Created Successfully...!!');
            }

            $error['errors']['domain']='Sorry subdomain modules not support in your plan....!!';
            return response()->json($error,422);
       
        
    }


    //store custom domain
    public function addCustomDomain(Request $request,$id)
    {
        $checkisvalid=$this->is_valid_domain_name($request->domain);
        if ($checkisvalid == false) {
            $error['errors']['domain']='Please enter valid domain....!!';
           return response()->json($error,422);
        }



        $info=Tenant::where('user_id',Auth::id())->where('status',1)->findorFail($id);
        $check_before= Domain::where([['tenant_id',$id],['type',3]])->first();
        if (!empty($check_before)) {
            $error['errors']['domain']='Oops you already customdomain created....!!';
            return response()->json($error,422);
        }

        
            if ($info->custom_domain == 'on') {
                 $validatedData = $request->validate([
                    'domain' => 'required|string|max:50',
                 ]);

                 $domain=strtolower($request->domain);
                 $input = trim($domain, '/');
                 if (!preg_match('#^http(s)?://#', $input)) {
                    $input = 'http://' . $input;
                 }
                $urlParts = parse_url($input);
                $domain = preg_replace('/^www\./', '', $urlParts['host']);
                
                $checkArecord=$this->dnscheckRecordA($domain);
                $checkCNAMErecord=$this->dnscheckRecordCNAME($domain);
                if ($checkArecord != true) {
                  $error['errors']['domain']='A record entered incorrectly.';
                  return response()->json($error,422);
                }

                if ($checkCNAMErecord != true) {
                    $error['errors']['domain']='CNAME record entered incorrectly.';
                    return response()->json($error,422);
                }

                $check= Domain::where('domain',$domain)->first();
                if (!empty($check)) {
                    $error['errors']['domain']='Oops domain name already taken....!!';
                    return response()->json($error,422);
                }

                $subdomain= new Domain;
                $subdomain->domain= $domain;
                $subdomain->tenant_id= $id;
                $subdomain->status=2;
                $subdomain->type=3;
                $subdomain->save();

                return response()->json('Custom Domain Created Successfully...!!');
            }

            $error['errors']['domain']='Sorry customdomain modules not support in your plan....!!';
            return response()->json($error,422);
        
    }

    //update subdomain
    public function updateSubdomain(Request $request,$id)
    {
        $info=Tenant::where('user_id',Auth::id())->findorFail($id);

      
            if ($info->sub_domain == 'on') {
                 $validatedData = $request->validate([
                    'subdomain' => 'required|string|max:50',
                 ]);

                 $domain=strtolower($request->subdomain).'.'.env('APP_PROTOCOLESS_URL');
                 $input = trim($domain, '/');
                 if (!preg_match('#^http(s)?://#', $input)) {
                    $input = 'http://' . $input;
                 }
                $urlParts = parse_url($input);
                $domain = preg_replace('/^www\./', '', $urlParts['host']);
                

                $check= Domain::where('domain',$domain)->where('tenant_id','!=',$id)->first();
                if (!empty($check)) {
                    $error['errors']['domain']='Oops domain name already taken....!!';
                    return response()->json($error,422);
                }

                $subdomain= Domain::where([['tenant_id',$id],['type',2]])->first();
                $subdomain->domain= $domain;                
                $subdomain->save();

                return response()->json('Subdomain Updated Successfully...!!');
            }

            $error['errors']['domain']='Sorry subdomain modules not support in your plan....!!';
            return response()->json($error,422);
      
    }

     //update custom domain
    public function updateCustomDomain(Request $request,$id)
    {

        $checkisvalid=$this->is_valid_domain_name($request->domain);
        if ($checkisvalid == false) {
            $error['errors']['domain']='Please enter valid domain....!!';
           return response()->json($error,422);
        }

        $info=Tenant::where('user_id',Auth::id())->findorFail($id);

        
            if ($info->custom_domain == 'on') {
                 $validatedData = $request->validate([
                    'domain' => 'required|string|max:50',
                 ]);

                 $domain=strtolower($request->domain);
                 $input = trim($domain, '/');
                 if (!preg_match('#^http(s)?://#', $input)) {
                    $input = 'http://' . $input;
                 }
                $urlParts = parse_url($input);
                $domain = preg_replace('/^www\./', '', $urlParts['host']);
                

                $check= Domain::where('domain',$domain)->where('tenant_id','!=',$id)->first();
                if (!empty($check)) {
                    $error['errors']['domain']='Oops domain name already taken....!!';
                    return response()->json($error,422);
                }

                $custom_domain= Domain::where([['tenant_id',$id],['type',3]])->first();
                if ($custom_domain->domain != $domain) {
                  $checkArecord=$this->dnscheckRecordA($domain);
                  $checkCNAMErecord=$this->dnscheckRecordCNAME($domain);
                  if ($checkArecord != true) {
                    $error['errors']['domain']='A record entered incorrectly.';
                    return response()->json($error,422);
                  }

                  if ($checkCNAMErecord != true) {
                    $error['errors']['domain']='CNAME record entered incorrectly.';
                    return response()->json($error,422);
                  }
                }

                $custom_domain->domain= $domain;                
                $custom_domain->save();

                return response()->json('Custom Domain Updated Successfully...!!');
            }

            $error['errors']['domain']='Sorry subdomain modules not support in your plan....!!';
            return response()->json($error,422);
       
    }

    //destroy subdomain
    public function destroy($id)
    {
        $info=Tenant::where('user_id',Auth::id())->findorFail($id);
        $subdomain= Domain::where([['tenant_id',$id],['type',2]])->delete();

        return back();
    }

    //destroy custom domain

    public function destroyCustomdomain($id)
    {
        $info=Tenant::where('user_id',Auth::id())->findorFail($id);
        $subdomain= Domain::where([['tenant_id',$id],['type',3]])->delete();
        return back();
    }

    //check is valid domain name
    public function is_valid_domain_name($domain_name)
    {
      if(filter_var(gethostbyname($domain_name), FILTER_VALIDATE_IP))
      {
        return TRUE;
      }
      return false;
   }

   //check A record
   public function dnscheckRecordA($domain)
   {
    if (env('MOJODNS_AUTHORIZATION_TOKEN') != null  && env('VERIFY_IP') == true) {
        try {
          $response=Http::withHeaders(['Authorization'=>env('MOJODNS_AUTHORIZATION_TOKEN')])->acceptJson()->get('https://api.mojodns.com/api/dns/'.$domain.'/A');
          $ip= $response['answerResourceRecords'][0]['ipAddress'];

          if ($ip == env('SERVER_IP')) {
              $ip= true;
          }
          else{
            $ip=false;
          }

        } catch (Exception $e) {
          $ip=false;
        }

        return $ip;
    }
     
     return true;
   } 


   //check crecord name
   public function dnscheckRecordCNAME($domain)
   {
    if (env('MOJODNS_AUTHORIZATION_TOKEN') != null) {
        if (env('VERIFY_CNAME') === true) {
        try {
          $response=Http::withHeaders(['Authorization'=>env('MOJODNS_AUTHORIZATION_TOKEN')])->acceptJson()->get('https://api.mojodns.com/api/dns/'.$domain.'/CNAME');
          if ($response->successful()) {
            $cname= $response['reportingNameServer'];

            if ($cname === env('CNAME_DOMAIN')) {
              $cname= true;
          }
          else{
           $cname=false;
        }

        } 
        else{
            $cname=false;
        }
              
          }
          catch (Exception $e) {
              $cname=false;
          }
          

        return $cname;
       }
      }
     
     return true;
   }

   //domain transfer view
   public function transferView($id)
   {
      Session::forget('domain_transfer_info');
      $info=Tenant::where('user_id',Auth::id())->where('status',1)->findorFail($id);
      return view('merchant.domain.transferview',compact('info'));
   }

   //send otp to the user
   public function sendOtp(Request $request,$id)
   {
       Session::forget('domain_transfer_info');
       $validatedData = $request->validate([
        'email' => 'required|email|max:50',
       ]);
       $info=Tenant::where('user_id',Auth::id())->findorFail($id);

       $user=User::where([['email',$request->email],['role_id',2],['status',1]])->first();
       if (empty($user)) {
        $error['errors']['email']='Opps invalid email...!!';
         return response()->json($error,422);
       }

       $data = [
            'name'    => Auth::user()->name,
            'otp' => rand(10000,30000),
            'tenant_id' => $id,
            'email'=>$request->email,
            'type'=>'otp'
        ];

        Session::put('domain_transfer_info',$data);
        if (env('QUEUE_MAIL') == 'on') {
            dispatch(new SendEmailJob($data));
        } else {
           Mail::to(Auth::user()->email)->send(new DomaintransferOtp($data));
        }
       
       
       return response()->json('Successfully OTP sent to your email');

   }

   //verify otp and change the owner
   public function verifyOtp(Request $request,$id)
   {
      abort_if(!Session::has('domain_transfer_info'),422);
      $validatedData = $request->validate([
          'otp' => 'required|numeric',
      ]);

      $info=Tenant::where('user_id',Auth::id())->findorFail($id);

      $data=Session::get('domain_transfer_info');
      
      if ($data['otp'] != $request->otp) {
          $error['errors']['otp']='Opps invalid OTP';
          return response()->json($error,422);
      }

      if ($data['tenant_id'] != $id) {
        $error['errors']['otp']='Invalid request';
        return response()->json($error,422);
      }

      $user=User::where([['email',$data['email']],['role_id',2],['status',1]])->first();

      if (empty($user)) {
        $error['errors']['email']='Opps user not exists';
        return response()->json($error,422);
      }
      $info->user_id=$user->id;
      $info->save();
      
      return response()->json('Store successfully transferred');

   }


   //developer view
   public function developerView($id)
   {
      $info=Tenant::where('user_id',Auth::id())->where('status',1)->findorFail($id);
      
      $plan=json_decode($info->plan_info);
      $instruction=Option::where('key','developer_instruction')->first();
      $instruction=json_decode($instruction->value ?? '');
      return view('merchant.domain.dev',compact('info','plan','instruction'));
   }


   //database migration fresh
   public function migrateWithSeed($id)
   {
     $info=Tenant::where('user_id',Auth::id())->where('status',1)->findorFail($id);
     \Config::set('app.env', 'local');
     Artisan::call('tenants:migrate-fresh --tenants='.$id);
     Artisan::call('tenants:seed --tenants='.$id);

     return response()->json('Database Reinstall Success');
   }

   //database new table migrate
   public function migrate($id)
   {
     \Config::set('app.env', 'local');
     $info=Tenant::where('user_id',Auth::id())->findorFail($id);
     Artisan::call('tenants:migrate --tenants='.$id);
     return response()->json('Database migrate success');
   }

   //cache clear for spesific tenant
   public function cacheClear($id)
   {
     $info=Tenant::where('user_id',Auth::id())->findorFail($id);
     if (env('CACHE_DRIVER') == 'memcached' || env('CACHE_DRIVER') == 'redis') {
          \Config::set('app.env', 'local');
          Artisan::call('cache:clear --tags='.$id);
     }
     $info->cache_version=rand(10,20);
     $info->save();

     return response()->json('Store cache cleared');
   }

   //remove with storage directory
   public function removeStorage($id)
   {
      $info=Tenant::where('user_id',Auth::id())->findorFail($id);
    
      Storage::disk(env('STORAGE_TYPE'))->deleteDirectory('uploads/'.$info->uid);
      Storage::disk('public')->deleteDirectory('uploads/'.$info->uid);
      
      
      return response()->json('Storage cleared successfully');
   }

   public function login($id)
   {
     $data=Tenant::where([['user_id',Auth::id()],['status',1],['will_expire','>',now()]])->whereHas('active_domains')->with('active_domains')->findorFail($id);
     $data->auth_token=Str::random(40).Auth::id();
     $data->save();

     $count=count($data->domains);
     $domain='';
     if ($count > 0) {
       foreach ($data->domains as $key => $value) {
        if ($key+1 == $count) {
         $domain=$value->domain;
        }
       }
     }
      
    

     return redirect(env('APP_PROTOCOL').$domain.'/make-login/'.Crypt::encryptString($data->auth_token));

   }

   //login with real domain

   public function loginByDomain($id)
   {
    $domain=Domain::where('status',1)->whereHas('tenant',function($q){
      return $q->where('user_id',Auth::id())->where('status',1);
    })->findorFail($id);

     $data=Tenant::where([['user_id',Auth::id()],['status',1],['will_expire','>',now()]])->findorFail($domain->tenant_id);
     $data->auth_token=Str::random(40).Auth::id();
     $data->save();
    return redirect(env('APP_PROTOCOL').$domain->domain.'/make-login/'.Crypt::encryptString($data->auth_token));
   }

}
