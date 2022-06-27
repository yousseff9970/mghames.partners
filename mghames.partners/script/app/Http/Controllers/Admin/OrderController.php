<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmailJob;
use App\Mail\OrderMail;
use App\Mail\OrderMailExpired;
use App\Models\Domain;
use App\Models\Getway;
use App\Models\Option;
use App\Models\Order;
use App\Models\Plan;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Userplan;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|View|Response
     */
    public function index(Request $request)
    {
        abort_if(!Auth()->user()->can('order.index'), 401);
        $all = Order::count();
        $active = Order::where('status', '1')->count();
        $inactive = Order::where('status', '0')->count();
        $pending = Order::where('status', '2')->count();
        $expired = Order::where('status', '3')->count();
        $st = '';
        if ($request->has('1') || $request->has('0') || $request->has('3') || $request->has('2')) {
            if ($request->has('1')) {
                $st = '1';
                $orders = Order::with('plan', 'getway', 'user','orderlog')->where('status', '1')->latest();
            }elseif ($request->has('3')) {
                $st = '3';
                $orders = Order::with('plan', 'getway', 'user','orderlog')->where('status', '3')->latest();
            }elseif ($request->has('2')) {
                $st = '2';
                $orders = Order::with('plan', 'getway', 'user','orderlog')->where('status', '2')->latest();
            }else {
                $st = '0';
                $orders = Order::with('plan', 'getway', 'user','orderlog')->where('status', '0')->latest();
            }
        } else {
            $orders = Order::with('plan', 'getway', 'user','orderlog')->latest();
        }
        if ($request->type == 'customer_email') {
            $orders=$orders->whereHas('user',function($q) use ($request)
            {
                return $q->where('email',$request->src);
            });
        }
        if ($request->type == 'trx') {
           $orders=$orders->where('trx',$request->src);
        }

        if ($request->type == 'tenant_id') {
           $orders=$orders->whereHas('orderlog',function($q) use ($request)
            {
                return $q->where('tenant_id',$request->src);
            });
        }

        $orders=$orders->paginate(30);
        return view('admin.order.index', compact('orders','active','inactive','all','pending','expired','st','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $plans = Plan::where('status', 1)->get();
        $getways = Getway::where('id','!=',14)->get();
        return view('admin.order.create', compact('plans','getways'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'plan_id'    => 'required',
            'getway_id'  => 'required',
            'email'      => 'required',
            'trx' => 'required',
            'store_id' => 'required',
        ]);
        $tenant_name = $request->store_id;
        $user = User::where('email',$request->email)->first();
        if(!$user) {
            $msg['errors']['error'] = "User Not Found!";
            return response()->json($msg, 401);
        }
        $tenant =  Tenant::where('user_id',$user->id)->findOrFail($tenant_name);
        if($tenant == null){
            $msg['errors']['error'] = "Tenant Not Found!";
            return response()->json($msg, 401);
        }
        $plan = Plan::where('id',$request->plan_id)->first();
        $plan_data = json_decode($plan->data);
        $getway = Getway::where('id',$request->getway_id)->first();
        $tax = Option::where('key','tax')->first();
        $tax_amount= ($plan->price / 100) * $tax->value;
        
        DB::beginTransaction();
        try { 
        
        $order = new Order;
        $order->plan_id = $request->plan_id;
        $order->user_id = $user->id;
        $order->getway_id = $request->getway_id;
        $order->trx = $request->trx;
        $order->price = $plan->price;
        $order->status = $request->status;
        $order->payment_status = $request->payment_status;
        $order->tax=$tax_amount;
        $order->will_expire = Carbon::now()->addDays($plan->duration);
        $order->save();
        $order->orderlog()->create(['tenant_id'=>$tenant_name]);


        if ($request->plan_assign == 'yes') {
            $features=json_decode($plan->data);
            $tenantupdate = Tenant::findOrFail($tenant_name);
            $tenantupdate->order_id = $order->id;
            $tenantupdate->will_expire = Carbon::now()->addDays($plan->duration);
            foreach ($features ?? [] as $key => $value) {
              $tenantupdate->$key=$value;
            }
            $tenantupdate->save();
        }
        DB::commit();
        } catch (\Throwable $th) {
              DB::rollback();

              $errors['errors']['error']='Opps something wrong';
              return response()->json($errors,401);
            
        }
        
        
        


        if ($request->email_status == '1') {
            $data = [
                'type' => 'order',
                'email' => $user->email,
                'name' =>  $user->name,
                'price' => $plan->price,
                'plan' => $plan->name,
                'trx' => $order->trx,
                'payment_getway' => $getway->name,
                'created_at' => $order->updated_at,
            ];

            if (env('QUEUE_MAIL') == 'on') {
                dispatch(new SendEmailJob($data));
            }else{
                Mail::to($user->email)->send(new OrderMail($data));
            }
        }

        return response()->json('Order Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $order = Order::with('tenant')->findOrFail($id);
        return view('admin.order.show',compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        abort_if(!Auth()->user()->can('order.edit'), 401);
        $plans = Plan::where('status', 1)->get();
        $getways = Getway::all();
        $order = Order::with('tenant')->findOrFail($id);
        return view('admin.order.edit',compact('order','plans','getways'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'getway_id'  => 'required',
            'email'      => 'required',
            'trx' => 'required|unique:orders,id,'.$id,
        ]);


        $user = User::where('email',$request->email)->first();
        $plan = Plan::where('id',$request->plan_id)->first();
        $getway = Getway::where('id',$request->getway_id)->first();
        
        

        $order = Order::with('orderlog')->findOrFail($id);
        $plan = Plan::findOrFail($order->plan_id);
        $order->user_id = $user->id;
        $order->getway_id = $request->getway_id;
        $order->trx = $request->trx;
        $order->status = $request->status;
        if($request->plan_assign == 'yes'){
        $order->will_expire = Carbon::now()->addDays($plan->duration);
        }
        $order->payment_status=$request->payment_status;
        $order->save();

        if (!empty($order->orderlog)) {
           $tenantupdate = Tenant::findOrFail($order->orderlog->tenant_id);
           $tenantupdate->order_id = $order->id;
           if($request->plan_assign == 'yes'){
            $features = json_decode($plan->data ?? '');
            foreach ($features ?? [] as $key => $value) {
              $tenantupdate->$key=$value;
            }
            $tenantupdate->will_expire = Carbon::now()->addDays($plan->duration);
            $tenantupdate->save();
           }
        }
        


        if ($request->email_status == '1') {
            $data = [
                'type' => 'order',
                'email' => $user->email,
                'name' =>  $user->name,
                'price' => $plan->price,
                'plan' => $plan->name,
                'trx' => $order->trx,
                'payment_getway' => $getway->name,
                'rate' => $getway->rate,
                'created_at' => Carbon::now()->format('Y-m-d'),
            ];

            if (env('QUEUE_MAIL') == 'on') {
                dispatch(new SendEmailJob($data));
            }else{
                Mail::to($user->email)->send(new OrderMail($data));
            }
        }
        return response()->json('Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        abort_if(!Auth()->user()->can('order.delete'), 401);
        Order::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Successfully Deleted'); 
    }

    
}
