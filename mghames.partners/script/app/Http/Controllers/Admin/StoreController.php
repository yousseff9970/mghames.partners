<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Domain;
use App\Models\Tenant;
use App\Models\Plan;
use App\Models\User;
use App\Models\Option;
use App\Models\Order;
use App\Models\Tenantorder;
use App\Models\Getway;
use Auth;
use DB;
use Str;
use Session;
use App\Models\Tenantmeta;
use Storage;
class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        abort_if(!Auth()->user()->can('domain.list'),401);
        $posts=Tenant::query()->with('user','domain')->latest()->paginate(40);
        
        return view('admin.domain.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!Auth()->user()->can('domain.create'),401);
        $plans=Plan::query()->where('status',1)->latest()->get();
        $getaways=Getway::where('status',1)->get();
        return view('admin.domain.create',compact('plans','getaways'));
    }

    public function dnsSettingView()
    {
        abort_if(!Auth()->user()->can('dns.settings'),401);
        $info=Option::where('key','dns_settings')->first();
        $info=json_decode($info->value ?? '');
        return view('admin.domain.dns',compact('info'));
    }

    public function dnsUpdate(Request $request)
    {
        $request->validate([            
            'dns_configure_instruction' => 'required',
            'support_instruction' => 'required',
        ]);

        $info=Option::where('key','dns_settings')->first();
        if (empty($info)) {
            $info=new Option;
            $info->key='dns_settings';
        }
        $data['dns_configure_instruction']=$request->dns_configure_instruction;
        $data['support_instruction']=$request->support_instruction;

        $info->value=json_encode($data);
        $info->save();

        return response()->json('Instruction Updated');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([            
            'store_id' => 'required|max:100|unique:tenants,id',
            'plan' => 'required',                    
            'user_email' => 'required|email', 
            'password' => 'required|confirmed',
            'address' => 'required',
            'city' => 'required',
            'country' => 'required',
            'postal_code' => 'required',
            'getaway' => 'required',
            'trx' => 'required',
            'status' => 'required'          
        ]);

        $data = [
            'store_name' => Str::slug($request->store_id),
            'email' => $request->user_email,
            'password' => $request->password,
            'address' => $request->address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'country' => $request->country
        ];
  
  
        Session::put('store_data',$data);

          if(env('AUTO_DB_CREATE') == false){
             $request->validate([            
                'db_name' => 'required|max:100',
                'db_username' => 'required|max:100',
                            
            ]);
          }
        ini_set('max_execution_time', '0');

        $user=User::where('email',$request->user_email)->where('role_id',2)->first();
        $plan=Plan::findorFail($request->plan);
        if(empty($user)){
            $error['errors']['email']='User not exists';
            return response()->json($error,422);
        }

        $exp_days =  $plan->duration;
        $expiry_date = \Carbon\Carbon::now()->addDays($plan->duration)->format('Y-m-d');

        if (env('SUBDOMAIN_TYPE') == 'real') {
            $subdomain=Str::slug($request->store_id).'.'.env('APP_PROTOCOLESS_URL');
            $subdomain_type=2;
        }
        else{
            $subdomain=Str::slug($request->store_id);
            $subdomain_type=2;
        }
        $tax = Option::where('key','tax')->first();

       
        $tax_amount= ($plan->price / 100) * $tax->value;
        $uid=\App\Tenant::count();
        $uid=$uid+1;
        $maxorder=Order::count();

        $status=1;
        $order = new Order;
      
        $order->plan_id = $plan->id;
        $order->user_id = $user->id;
        $order->getway_id = $request->getaway;
        $order->trx = $request->trx;
        $order->tax = $tax_amount;
        $order->price = $plan->price;
        $order->status = 1;
        $order->payment_status = 1;
        $order->will_expire = \Carbon\Carbon::now()->addDays($plan->duration);
        $order->save();
        $order_id=$order->id;
        if(env('AUTO_DB_CREATE') == true){
          $tenant1 = Tenant::create(['id' => Str::slug($request->store_id),'user_id'=>$user->id,'will_expire'=>$expiry_date,'plan_info'=>$plan->data,'status'=>$request->status,'uid'=>$uid,'order_id' => $order_id]);
          $tenant1->domains()->create(['domain'=>$subdomain,'type'=>$subdomain_type]);

          $log=new Tenantorder;
          $log->order_id=$order_id;
          $log->tenant_id=Str::slug($request->store_id);
          $log->save();




        }
        else{
          DB::beginTransaction();
        
           
            
            try {
              
                $db_data='{"tenancy_db_name":"'.$request->db_name.'","tenancy_db_username":"'.$request->db_username.'","tenancy_db_password":"'.$request->db_password.'"}';
                $tenant = new \App\Tenant;
                $tenant->id=Str::slug($request->store_id);
                $tenant->will_expire=$expiry_date;
                $tenant->data=$db_data;
                $tenant->user_id=$user->id;
                $tenant->plan_info=$plan->data;
                $tenant->status=$request->status;
                $tenant->uid=$uid;
                $tenant->order_id=$order_id;
                $tenant->save();

                $domain= new \App\Models\Domain;
                $domain->domain=$subdomain;
                $domain->tenant_id=Str::slug($request->store_id);
                $domain->type=$subdomain_type;
                $domain->save();

                $log=new Tenantorder;
                $log->order_id=$order_id;
                $log->tenant_id=Str::slug($request->store_id);
                $log->save();
                if ($request->migrate == 'yes') {
                \Artisan::call('tenants:migrate-fresh --tenants='.Str::slug($request->store_id));
                \Artisan::call('tenants:seed --tenants='.Str::slug($request->store_id));
               }
              

              
            
            DB::commit();
           
            } catch (Exception $e) {
              DB::rollback();

              $error['errors']['email']='Opps database credintials is wrong';
              return response()->json($error,422);
            }
        }
        
        if($plan->is_trial == 1)
        {
            $store_lock = true;
        }else{
            $store_lock = false;
        }

        $tenantdata = [
            'email' => $request->user_email,
            'address' => $request->address,
            'city' => $request->city,
            'country' => $request->country,
            'password' => $request->password,
            'postal_code' => $request->postal_code,
            'store_lock' => $store_lock
        ];

        $tenantmeta = new Tenantmeta();
        $tenantmeta->tenant_id = Str::slug($request->store_id);
        $tenantmeta->key = 'tenant';
        $tenantmeta->value = json_encode($tenantdata);
        $tenantmeta->save();


        Session::forget('store_data');
    
        return response()->json('Store Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(!Auth()->user()->can('domain.show'),401);
        $info=Tenant::with('subdomain','customdomain')->findorFail($id);
        return view('admin.domain.show',compact('info'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(!Auth()->user()->can('domain.edit'),401);
        $info=Tenant::findorFail($id);
        return view('admin.domain.edit',compact('info'));
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([            
            'store_id' => 'required|max:100|unique:tenants,id,' . $id,                 
            'user_email' => 'required|email',            
        ]);


        $user=User::where('email',$request->user_email)->where('role_id',2)->first();
        
        if(empty($user)){
            $error['errors']['email']='User not exists';
            return response()->json($error,422);
        }

        $row=DB::table('tenants')
        ->where('id', $id)
        ->update([
        'id' => Str::slug($request->store_id),
        'user_id' => $user->id,
        'status' => $request->status,
        ]);

        

        return response()->json('Domain Updated');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function databaseView($id)
    {
        abort_if(!Auth()->user()->can('domain.edit'),401);
        $info=Tenant::findorFail($id);
        return view('admin.domain.dbconfig',compact('info'));
    }

   
    
    //update databaseinfo and migration seeding
    public function databaseUpdate(Request $request,$id)
    {
        $request->validate([            
            'tenancy_db_name' => 'required|max:100',                        
        ]);
        ini_set('max_execution_time', '0');

        
        
        DB::beginTransaction();
        try {
       
         $tenant =  Tenant::findorFail($id);
         if (isset($request->db_username)) {
         $tenant->tenancy_db_username=$request->db_username;
         }
         if (isset($request->db_password)) {
         $tenant->tenancy_db_password=$request->db_password;
          }
         if (isset($request->tenancy_db_name)) {
          $tenant->tenancy_db_name=$request->tenancy_db_name;
         }
          
         $tenant->save();

         \Config::set('app.env', 'local');

        if ($request->migrate == 'yes') {           
            \Artisan::call('tenants:migrate --tenants='.Str::slug($id));
        }
        

        if ($request->migrate_fresh == 'yes') {            
            \Artisan::call('tenants:migrate-fresh --tenants='.Str::slug($id));
            \Artisan::call('tenants:seed --tenants='.Str::slug($id));          
           
        }

        DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            $error['errors']['database']='Opps something wrong with demoimport please check the database credintials';
            return response()->json($error,422);
        }       

        return response()->json('Update Successfully');
    }


     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function planView($id)
    {
        abort_if(!Auth()->user()->can('domain.edit'),401);
        $info=Tenant::findorFail($id);
        $plan=new \App\Models\Plan;
        $features=$plan->plandata;
       
        return view('admin.domain.planconfig',compact('info','features'));
    }

    //update plandata
    public function planUpdate(Request $request,$id)
    {
        


        $tenant = Tenant::findorFail($id);

        foreach ($request->plan ?? [] as $key => $value) {
           $tenant->$key=$value;
        }
        $tenant->will_expire=$request->will_expire;
       
        $tenant->save();

        return response()->json('Plan data updated');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        abort_if(!Auth()->user()->can('domain.delete'),401);
        ini_set('max_execution_time', '0');
        

        if($request->method == 'delete' && count($request->ids ?? []) > 0){
           
              
                foreach($request->ids ?? [] as $row){
                  $tenant=\App\Models\Tenant::find($row);
                  Storage::disk(env('STORAGE_TYPE'))->deleteDirectory('uploads/'.$tenant->uid);
                  Storage::disk('public')->deleteDirectory('uploads/'.$tenant->uid);
                   try {
                    \App\Models\Tenant::destroy($row);
                   } catch (\Throwable $th) {
                       
                   }
                   
                }
                
            
        }
        
        


        return response()->json('Store Deleted successfully');
    }

    public function instructionView()
    {
       $info=Option::where('key','developer_instruction')->first();
       $info=json_decode($info->value ?? '');

       return view('admin.domain.instruction',compact('info'));
    }

    public function instructionUpdate(Request $request)
    {

      $data['db_migrate_fresh_with_demo']=$request->db_migrate_fresh_with_demo;
      $data['db_migrate']=$request->db_migrate;
      $data['remove_cache']=$request->remove_cache;
      $data['remove_storage']=$request->remove_storage;

      $info=Option::where('key','developer_instruction')->update(['value'=>json_encode($data)]);

      return response()->json('instruction Updated');
    }
}
