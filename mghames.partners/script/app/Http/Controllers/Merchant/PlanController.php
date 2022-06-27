<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmailJob;
use App\Mail\PlanMail;
use App\Models\Order;
use App\Models\Plan;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Domain;
use App\Models\Option;
use App\Models\Ordermeta;
use App\Models\Tenantmeta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\Getway;
use Illuminate\Support\Facades\Crypt;
use Storage;
use App\Models\Tenantorder;
use Database\Seeders\Tenant\TenantTermSeeder;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = Plan::where([['status', 1], ['is_default', 0]])->get();
        $orders = Order::where('user_id', Auth::id())->with('plan', 'getway')->latest()->paginate(25);
        return view('merchant.plan.index', compact('plans', 'orders'));
    }

    public function gateways($planid)
    {
        $plan = Plan::where([['status',1]])->findOrFail($planid);
        $gateways = Getway::where('id', '!=', 13)->where('status',1)->get();
        $plan = Plan::findOrFail($planid);
        $tax = Option::where('key','tax')->first();
        $plan_data = json_decode($plan->data);

        if($plan->is_trial == 1)
        {
            $domain['name'] = Session::get('store_data')['store_name'];
            Session::put('domain_data', $domain);

            
            $tax_amount= ($plan->price / 100) * $tax->value;
            // Insert transaction data into order table
           

            

            $order = new Order;
            $order->plan_id = $plan->id;
            $order->user_id = Auth::id();
            $order->getway_id = 13;
            $order->tax = $tax_amount;
            $order->price = $plan->price;
            $order->status = 1;
            $order->payment_status = 1;
            $order->will_expire = Carbon::now()->addDays($plan->duration);
            $order->save();

            Session::put('order_id', $order->id);
            Session::put('plan',$plan->id);            

            return redirect()->route('merchant.plan.enroll');
        }else{
            return view('merchant.plan.gateways', compact('gateways', 'plan','plan_data','tax'));
        }
    }
    
    public function deposit(Request $request)
    {
        $plan = Plan::where('status',1)->findOrFail($request->plan_id);

        if ($plan->is_trial == 1) {
            $order = Order::where([['plan_id',$request->plan_id],['user_id',Auth::id()]])->first();
            if($order == null){
                $data['payment_status'] = 1;
                $data['payment_type'] = 'new_plan_enroll';
                $data['name'] = Str::slug(Session::get('store_data')['store_name']);
                $data['getway_id'] = Getway::where('name','free')->pluck('id')->first() ?? 13;
                $data['payment_id'] = $this->uniquetrx();    
                Session::put('domain_data', $data);        
                Session::put('payment_info', $data);
                Session::put('plan', $request->plan_id);
                return redirect()->route('merchant.payment.success');
            }else{
                return redirect()->route('merchant.plan.index')->with('message','Already enrolled in Trial Plan! Select Other Plan')->with('type','danger');
            }
        }

        $gateway = Getway::where([['status',1],['id','!=',13]])->findOrFail($request->id);
        $gateway_info = json_decode($gateway->data); //for creds
        
        $plan_data = json_decode($plan->data);
        $domain_id=Tenant::find(Str::slug($request->name));
        if(!empty($domain_id)){
            Session::flash('error','The store name has already been taken.');
            return back();
        }

        if ($gateway->is_auto == 0 && $gateway->id != 14) {
            $request->validate([
                'screenshot' => 'required|image|max:800',
                'comment' => 'required|string|max:100',
            ]);
           $payment_data['comment'] = $request->comment;
            if ($request->hasFile('screenshot')) {
                

                $path='uploads/'.strtolower(env('APP_NAME')).'/payments'.date('/y/m/');
                $name = uniqid().date('dmy').time(). "." . strtolower($request->screenshot->getClientOriginalExtension());

                Storage::disk(env('STORAGE_TYPE'))->put($path.$name, file_get_contents(Request()->file('screenshot')));

                $image= Storage::disk(env('STORAGE_TYPE'))->url($path.$name);

                $payment_data['screenshot'] = $image;
            }  
        }
        $tax = Option::where('key','tax')->first();
        $payment_data['currency'] = $gateway->currency_name ?? 'USD';
        $payment_data['email'] = Auth::user()->email;
        $payment_data['name'] = Auth::user()->name;
        $payment_data['phone'] = $request->phone;
        $payment_data['billName'] = $plan->name;
        $payment_data['amount'] = $plan->price;
        $payment_data['test_mode'] = $gateway->test_mode;
        $payment_data['charge'] = $gateway->charge ?? 0;
        $payment_data['pay_amount'] = (round($plan->price + (($plan->price / 100) * $tax->value), 2) * $gateway->rate) + $gateway->charge ?? $request->session()->get('usd_amount');
        $payment_data['getway_id'] = $gateway->id;
        $payment_data['payment_type'] = 'new_plan_enroll';
        $payment_data['request'] = $request->except('_token');
        $payment_data['request_from'] = 'merchant';
        Session::put('plan', $request->plan_id);
        $domain['name'] = Str::slug($request->name);
        Session::put('domain_data', $domain);
        if (!empty($gateway_info)) {
            foreach ($gateway_info as $key => $info) {
                $payment_data[$key] = $info;
            };
        }

       
        return $gateway->namespace::make_payment($payment_data);
    }

    public function success(Request $request)
    {
      
        if (!session()->has('payment_info') && session()->get('payment_info')['payment_status'] != 1) {
            abort(404);
        }

       // abort_if(session()->get('payment_info')['payment_type'] != 'new_plan_enroll',404);
        $tax = Option::where('key','tax')->first();
        //if transaction successfull
        $plan_id = $request->session()->get('plan');
        $plan = Plan::findOrFail($plan_id);

        $getway_id = $request->session()->get('payment_info')['getway_id'];
        $gateway = Getway::findOrFail($getway_id);
        $trx = $request->session()->get('payment_info')['payment_id'];
        $payment_status = $request->session()->get('payment_info')['payment_status'] ?? 0;
        $status = $request->session()->get('payment_info')['status'] ?? 1;

       
        $tax_amount= ($plan->price / 100) * $tax->value;
        // Insert transaction data into order table
       
        DB::beginTransaction();
        try {  
         


         
        $order = new Order;
        $order->plan_id = $plan_id;
        $order->user_id = Auth::id();
        $order->getway_id = $gateway->id;
        $order->trx = $trx;
        $order->tax = $tax_amount;
        $order->price = $plan->price;
        $order->status = $status;
        $order->payment_status = $payment_status;
        $order->will_expire = Carbon::now()->addDays($plan->duration);
        $order->save();

        Session::put('order_id', $order->id);

        //ordermeta
        if($gateway->is_auto == 0){
            $data = Session::get('payment_info')['meta'] ?? '';
            
            $order->ordermeta()->create([
                'key'=>'orderinfo',
                'value'=>json_encode($data)
            ]);

        }

         DB::commit();

        } catch (\Throwable $th) {
          DB::rollback();
           Session::forget('payment_info');
           Session::flash('message', 'Something wrong please contact with support..!');
           Session::flash('type', 'error');
          return redirect()->route('merchant.plan.index');
        }

        
        $status = Session::get('payment_info')['payment_status'];
        
        Session::put('order_status', $status);
        Session::flash('message', 'Transaction Successfully Complete!');
        Session::flash('type', 'success');
        Session::forget('payment_info');
        
       
        if ($status != 0) {
            return redirect()->route('merchant.plan.enroll');
        }else{
            return redirect()->route('merchant.plan.index');
        }
    }

    public function enroll()
    { 
        abort_if(!Session::has('domain_data'),403);
        if (Session::has('domain_data')) {
           $domain_data = Session::get('domain_data');
        }
        $plan = Session::get('plan');
        $order_id = Session::get('order_id');
        abort_if(empty($order_id),404);

        
        return redirect()->route('merchant.plan.strorecreate');
        
    }

    public function strorecreate()
    {
        abort_if(!Session::has('store_data'),403);
        return view('merchant.domain.storecreate');
    }

    public function storePlan(Request $request)
    {

        if (!Session::has('domain_data')) {
            $error['errors']['email']='Domain already created!!';
            
            return response()->json(['data' => ['redirect_url'=>route('merchant.domain.list'),'store_status'=>0,'response'=>'success']]);
        }

        $plan_id = Session::get('plan');
        $name = Str::slug(Session::get('store_data')['store_name']);

        $order_id = Session::get('order_id');

        abort_if(empty($order_id),404);
        
        ini_set('max_execution_time', '0');
        
        $order = Order::findOrFail($order_id);
        $gateway = Getway::findOrFail($order->getway_id);
        $plan=Plan::findorFail($plan_id);
        $totalAmount = $plan->price * $gateway->rate;
        $exp_days =  $plan->duration;
        $expiry_date = \Carbon\Carbon::now()->addDays($exp_days)->format('Y-m-d');

        $domain = env('APP_URL_WITH_TENANT'). Str::slug($name);

        $status= env('AUTO_TENANT_APPROVE') == true ? 1 : 2;
        $plan_info=json_decode($plan->data ?? '');

        if(env('AUTO_DB_CREATE') == true) {
            if ($order->status == 1) {
                $tenant = new  Tenant;
                foreach ($plan_info ?? [] as $key => $value) {
                 $tenant->$key=$value;
                }
                $tenant->status=$status;
            }
            else{
                $tenant=new \App\Tenant;
                $tenant->status = 2;
            }
        }
        else{
            $tenant=new \App\Tenant;
            $tenant->status = 2;
        }
       
        $tenant->id=Str::slug($name);
        $tenant->uid=\App\Tenant::count()+1;
        $tenant->order_id=$order->id;
        $tenant->user_id=Auth::id();
        $tenant->will_expire=$expiry_date;
        
        $tenant->save();

        DB::beginTransaction();
          try {  
           
           
           $tenant_id=Str::slug($name);
          
           $domain_name = $name.'.'.env('APP_PROTOCOLESS_URL');
           $type = 2;
           $status = env('AUTO_SUBDOMAIN_APPROVE') == true ? 1 : 2;
            if(env('AUTO_DB_CREATE') == true && $tenant->status == 1) {
            $tenant->domains()->create(['domain'=>$domain_name,'tenant_id'=>$tenant_id,'type'=>$type,'status'=>$status]);

            
            $tenant->tenantorderlog()->create(['order_id'=>$order->id]);
            }

            else{
                $domain=new Domain;
                $domain->domain=$domain_name;
                $domain->tenant_id=$tenant_id;
                $domain->type=$type;
                $domain->status=$status;
                $domain->save();

                $log=new Tenantorder;
                $log->order_id=$order->id;
                $log->tenant_id=$tenant_id;
                $log->save();

            }

            DB::commit();
            
    
            } catch (\Throwable $th) {
              DB::rollback();
                return $th;
              $error['errors']['email']='Error Occured';
            
             return response()->json($error,422);
          }
        
        Session::forget('order_id');
        
        

        $data = [
            'type'    => 'plan',
            'email'   => env('MAIL_TO'),
            'name'    => Auth::user()->name,
            'message' => "Successfully Paid " . round($totalAmount, 2) . " (charge included) for " . $plan->name . " plan",
        ];

        if (env('QUEUE_MAIL') == 'on') {
            dispatch(new SendEmailJob($data));
        } else {
            Mail::to(env('MAIL_TO'))->send(new PlanMail($data));
        }

        Session::forget('domain_data');
        Session::forget('order_id');

        if($plan->is_trial == 1)
        {
            $store_lock = true;
        }else{
            $store_lock = false;
        }

       


        if(env('AUTO_DB_CREATE') == true && $tenant->status == 1)
        {
            if(env('AUTO_SUBDOMAIN_APPROVE') == true)
            {
                $db  = Session::get('store_data')['db'];
                $seed = new TenantTermSeeder;
                $seed->run($db);
                $redirect_url = '//'.$name.'.'.env('APP_PROTOCOLESS_URL').'/redirect/login?email='.Session::get('store_data')['email'].'&&password='.Session::get('store_data')['password'];
            }else{
                
                $db  = Session::get('store_data')['db'];
                $seed = new TenantTermSeeder;
                $seed->run($db);
                $redirect_url = env('APP_URL_WITH_TENANT').$name.'/redirect/login?email='.Session::get('store_data')['email'].'&&password='.Session::get('store_data')['password'];
              
            }
        }else{
            
            $redirect_url = route('merchant.domain.list');
            
        }
       
        
        Session::forget('store_data');
        Session::forget('plan');
        

        if(env('AUTO_DB_CREATE') == true && $tenant->status == 1)
        {
            
            $db  = Session::get('store_data')['db'];
                $seed = new TenantTermSeeder;
                $seed->run($db);
            return response()->json(['data' => ['redirect_url'=>$redirect_url,'store_status'=>$tenant->status,'response'=>'success']]);
        }else{
            
            $db  = Session::get('store_data')['db'];
                $seed = new TenantTermSeeder;
                $seed->run($db);
            return response()->json(['data' => ['redirect_url'=>$redirect_url,'store_status'=>$tenant->status,'response'=>'success_redirect']]);
        }

    }

    public function activateDomain(Request $request){

    }

    public function failed()
    {
        Session::flash('message', 'Transaction Error Occured!!');
        Session::flash('type', 'danger');
        Session::forget('payment_info');
        Session::forget('payment_type');
        return redirect()->route('merchant.plan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('merchant.plan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $order = Order::with('plan', 'getway', 'user','ordermeta','orderlog')->where('user_id',Auth::id())->findOrFail($id);
        return view('merchant.plan.show', compact('order'));

    }

    public function invoicePdf($id)
    {
        $data = Order::with('plan', 'getway', 'user')->where('user_id',Auth::id())->findOrFail($id);
        $pdf = PDF::loadView('merchant.plan.invoice-pdf', compact('data'));
        return $pdf->download('order-invoice.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('merchant.plan.edit');
    }

    

   public function renewView($id)
   {
        $info=Tenant::where('user_id',Auth::id())->with('orderwithplan')->findorFail($id);
        if ($info->orderwithplan->plan->is_trial == 1) {
            return redirect()->route('merchant.domain.plan',$id);
        }
       return redirect('/partner/plancharge/'.$id.'/'.$info->orderwithplan->plan->id);
   }

   public function changePlan($id)
   {
      $info=Tenant::where('user_id',Auth::id())->with('orderwithplan')->findorFail($id);
      $plans = Plan::where([['status', 1], ['is_default', 0],['is_trial', 0],['price','>',0]])->latest()->get();
      $symbol=Option::where('key','currency_symbol')->first()->value ?? 'USD'; 
      return view('merchant.plan.changeplan',compact('plans','info','symbol'));

   }

   public function ChanePlanGateways($domain,$id)
   {
        $info=Tenant::where('user_id',Auth::id())->with('orderwithplan')->findorFail($domain);
        $plan = Plan::where([['status', 1], ['is_default', 0],['is_trial', 0],['price','>',0]])->find($id);

        if (empty($plan)) {
        return redirect()->route('merchant.domain.plan',$domain);
        }

        // if ($id != $info->orderwithplan->plan_id) {
        //   abort(404);
        // }
        $gateways = Getway::where('name', '!=', 'free')->where('status',1)->get();
        
        $tax = Option::where('key','tax')->first();
        $plan_data = json_decode($plan->data);
                
        return view('merchant.plan.gateways', compact('gateways', 'plan','plan_data','tax','info'));
   }

   public function renewCharge(Request $request,$id)
   {
      $info=Tenant::where('user_id',Auth::id())->with('orderwithplan')->findorFail($id);
      $plan = Plan::where([['status', 1], ['is_default', 0],['is_trial', 0],['price','>',0]])->findOrFail($request->plan_id);
      $gateway = Getway::where([['status',1],['id','!=',13]])->findOrFail($request->id);
      $gateway_info = json_decode($gateway->data); //for creds
      $plan_data = json_decode($plan->data);
        

        if ($gateway->image_accept == 1) {
            $request->validate([
                'screenshot' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'comment' => 'required|string|max:100',
            ]);
           $payment_data['comment'] = $request->comment;
            if ($request->hasFile('screenshot')) {
                

                $path='uploads/'.strtolower(env('APP_NAME')).'/payments'.date('/y/m/');
                $name = uniqid().date('dmy').time(). "." . strtolower($request->screenshot->getClientOriginalExtension());

                Storage::disk(env('STORAGE_TYPE'))->put($path.$name, file_get_contents(Request()->file('screenshot')));

                $image= Storage::disk(env('STORAGE_TYPE'))->url($path.$name);

                $payment_data['screenshot'] = $image;
            }  
        }
        $tax = Option::where('key','tax')->first();
        $payment_data['currency'] = $gateway->currency_name ?? 'USD';
        $payment_data['email'] = Auth::user()->email;
        $payment_data['name'] = Auth::user()->name;
        $payment_data['phone'] = $request->phone;
        $payment_data['billName'] = $plan->name;
        $payment_data['amount'] = $plan->price;
        $payment_data['test_mode'] = $gateway->test_mode;
        $payment_data['charge'] = $gateway->charge ?? 0;
        $payment_data['pay_amount'] = (round($plan->price + (($plan->price / 100) * $tax->value), 2) * $gateway->rate) + $gateway->charge ?? $request->session()->get('usd_amount');
        $payment_data['getway_id'] = $gateway->id;
        $payment_data['payment_type'] = 'renew_plan';
     
        $payment_data['request_from'] = 'merchant';
        Session::put('plan', $request->plan_id);
        $domain['name'] = $id;
        Session::put('domain_data', $domain);

        if (!empty($gateway_info)) {
            foreach ($gateway_info as $key => $info) {
                $payment_data[$key] = $info;
            };
        }
        // return $payment_data;
        Session::forget('fund_callback');
        Session::put('fund_callback',[
            'success_url' => 'partner/plan-renew/redirect/success',
            'cancel_url' => 'partner/plan-renew/redirect/fail'
        ]);

        return $gateway->namespace::make_payment($payment_data);
   }


   public function renewSuccess(Request $request)
   {

    
         if (!session()->has('payment_info')) {
            abort(404);
        }

        //abort_if(session()->get('payment_info')['payment_type'] != 'renew_plan',404);


        $tax = Option::where('key','tax')->first();
        //if transaction successfull
        $plan_id = $request->session()->get('plan');
        $plan = Plan::findOrFail($plan_id);
        $getway_id = $request->session()->get('payment_info')['getway_id'];
        $gateway = Getway::findOrFail($getway_id);
        $trx = $request->session()->get('payment_info')['payment_id'];
        $payment_status = $request->session()->get('payment_info')['payment_status'] ?? 0;
        $status = $request->session()->get('payment_info')['status'] ?? 1;
       
        $tax_amount= ($plan->price / 100) * $tax->value;
        // Insert transaction data into order table
        

        DB::beginTransaction();
        try {  
            DB::commit();

            $order = new Order;
           
            $order->plan_id = $plan_id;
            $order->user_id = Auth::id();
            $order->getway_id = $gateway->id;
            $order->trx = $trx;
            $order->tax = $tax_amount;
            $order->price = $plan->price;
            $order->status = $status;
            $order->payment_status = $payment_status;
            $order->will_expire = Carbon::now()->addDays($plan->duration);
            $order->save();

            $order->orderlog()->create(['tenant_id'=>Session::get('domain_data')['name']]);


        //ordermeta
            if($gateway->is_auto == 0){
                $data = Session::get('payment_info')['meta'] ?? '';
                
                $ordermeta = new Ordermeta();
                $ordermeta->key = 'orderinfo';
                $ordermeta->order_id = $order->id;
                $ordermeta->value = json_encode($data);
                $ordermeta->save();
            }

            $tenant_id=Session::get('domain_data');
            $status = Session::get('payment_info')['payment_status'];
            if ($status == 1) {

              $plan_info=json_decode($plan->data ?? '');

              $this->tenantUpdate(Session::get('domain_data')['name'],$plan->duration,$order->id,$plan_info);
              
           
           }

           Session::put('order_id', $order->id);
           Session::put('order_status', $status);
           Session::flash('message', 'Transaction Successfully Complete!');
           Session::flash('type', 'success');
           Session::forget('payment_info');
           Session::forget('domain_data');
           Session::forget('fund_callback');
            

         } catch (\Throwable $th) {
          DB::rollback();

          
          return $this->renewFail();
        }


        return redirect('/partner/domain');
        
       
   }

   public function tenantUpdate($tenant_id,$duration,$order_id,$plan_info)
   {
      $data=Tenant::where('user_id',Auth::id())->find($tenant_id);
      $data->will_expire=Carbon::now()->addDays($duration)->format('Y-m-d');
      $data->order_id=$order_id;
      foreach ($plan_info ?? [] as $key => $value) {
         $data->$key=$value;
     }
     $data->save();

     return true;
   }

   public function renewFail()
   {
        Session::flash('message', 'Transaction Error Occured!!');
        Session::flash('type', 'danger');
        Session::forget('payment_info');
        Session::forget('payment_type');
        return redirect('/partner/domain');
   }

    public function filter_protocol($url)
    {
        $domain=strtolower($url);
        $input = trim($domain, '/');
        if (!preg_match('#^http(s)?://#', $input)) {
            $input = 'http://' . $input;
        }
        $urlParts = parse_url($input);
        $domain = preg_replace('/^www\./', '', $urlParts['host']);
        $full_domain=rtrim($domain, '/');

        return $full_domain;
    }


    function uniquetrx(){  
        $str = Str::random(40);
        $check = Order::where('trx', $str)->first();
        if($check == true){
            $str = $this->uniquetrx();
        }
        return $str;
    }

    public function lock(Request $request,$id)
    {

        $tenantmeta = Tenantmeta::where('tenant_id',$id)->first();
        $data = json_decode($tenantmeta->value);
        if($request->type == 'unlock')
        {
            $data->store_lock = false;
        }else{
            $data->store_lock = true;
        }
        $tenantmeta->value = json_encode($data);
        $tenantmeta->save();

        if($request->type == 'unlock')
        {
            return response()->json('Store Unlocked!');
        }else{
            return response()->json('Store Locked!');
        }
    }
}
