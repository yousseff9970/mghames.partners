<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Order;
use App\Models\Option;
use Auth;
class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       abort_if(!Auth()->user()->can('plan.index'),401);
       
       $posts=Plan::query()->withCount('active_users')->withCount('orders')->latest()->get();
       return view('admin.plan.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!Auth()->user()->can('plan.create'),401);
        $plan_object= new  Plan;
        $features=$plan_object->plandata;
        return view('admin.plan.create',compact('features'));
    }

    public function settings()
    {
        abort_if(!Auth()->user()->can('plan.index'),401);
        $currency=Option::where('key','currency')->first();
     
        $tax=Option::where('key','tax')->first();
        $automatic_renew_plan_mail=Option::where('key','automatic_renew_plan_mail')->first();
        $plan_renewal_massege=json_decode($automatic_renew_plan_mail->value);

        $cron_option=Option::where('key','cron_option')->first();
        $cron_option=json_decode($cron_option->value);

        $currency_symbol=Option::where('key','currency_symbol')->first();

       
        return view('admin.plan.settings',compact('currency','plan_renewal_massege','cron_option','currency_symbol','tax'));
    }

    public function settingsUpdate(Request $request, $type)
    {
        if ($type == 'general') {
            $validated = $request->validate([
                'currency' => 'required|max:100',
                'currency_symbol' => 'required',
                'tax' => 'required',
               

            ]);

            Option::where('key','currency')->update(['value'=>strtoupper($request->currency)]);
            Option::where('key','currency_symbol')->update(['value'=>$request->currency_symbol]);
            Option::where('key','tax')->update(['value'=>$request->tax]);
            

            return response()->json(['General settings updated']);
        }

        if ($type == 'renewal') {
            $validated = $request->validate([
                'order_complete' => 'required',
                'user_balance_low' => 'required',
                'plan_disabled' => 'required',

            ]);

            $data['order_complete']=$request->order_complete;
            $data['user_balance_low']=$request->user_balance_low;
            $data['plan_disabled']=$request->plan_disabled;

            Option::where('key','automatic_renew_plan_mail')->update(['value'=>json_encode($data)]);
            
            return response()->json(['Alert Massege updated']);
        }

        if ($type == 'cron') {
            $validated = $request->validate([
                'days' => 'required',
                'alert_message' => 'required',
                'expire_message' => 'required',
                'trial_expired_message' => 'required',
            ]);

            $data['days']=$request->days;
            $data['alert_message']=$request->alert_message;
            $data['expire_message']=$request->expire_message;
            $data['trial_expired_message']=$request->trial_expired_message;

            Option::where('key','cron_option')->update(['value'=>json_encode($data)]);
            
            return response()->json(['Settings updated']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|unique:plans|max:100',
            'duration' => 'required|numeric',
            'price' => 'required',
        ]);
       
        $info=new Plan();
        
        $info->name=$request->name;
        $info->duration=$request->duration;
        $info->price=$request->price;
        $info->status=$request->status;
        $info->is_featured=$request->is_featured ?? 0;
        $info->is_trial=$request->is_trial ?? 0;
        $info->data=json_encode($request->plan ?? '');
        $info->save();
        return response()->json('Plan created successfully..!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $orders = Order::with('plan', 'getway', 'user','orderlog')->where('plan_id',$id)->latest()->paginate(30);
        return view('admin.plan.show',compact('orders'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(!Auth()->user()->can('plan.edit'),401);
        $info=Plan::findorFail($id);
        $data=json_decode($info->data ?? '');
        $plan_object= new  Plan;
        $features=$plan_object->plandata;
        return view('admin.plan.edit',compact('info','data','features'));
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
        $validated = $request->validate([
            'name' => 'required|max:100',
            'duration' => 'required|numeric',
            'price' => 'required',
        ]);
        
        
        $plan=Plan::findorFail($id);
        $plan->name=$request->name;
        $plan->duration=$request->duration;
        $plan->price=$request->price;
        $plan->status=$request->status;
        $plan->is_featured=$request->is_featured ?? 0;
        $plan->is_trial=$request->is_trial ?? 0;
        $plan->data=json_encode($request->plan ?? '');
        $plan->save();
        return response()->json('Plan updated successfully..!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        abort_if(!Auth()->user()->can('plan.delete'),401);
        if($request->method=='delete'){
            Plan::whereIn('id',$request->ids)->doesnthave('active_users')->delete();
        }

        return response()->json('Plan Deleted');
    }
}
