<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Option;
use Auth;
class CronController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!Auth()->user()->can('cron.settings'),401);
        $option = Option::where('key', 'cron_option')->first();
        $option = json_decode($option->value ?? '');

        $automatic_renew_plan_mail = Option::where('key', 'automatic_renew_plan_mail')->first();
        $automatic_renew_plan_mail = json_decode($automatic_renew_plan_mail->value ?? '');
        return view('admin.option.cron', compact('option','automatic_renew_plan_mail'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
            $option = Option::where('key', $id)->first();

            if ($id == 'cron_option') {
               $data = [
                    "status"              => $request->status,
                    "days"                => $request->days,
                    "assign_default_plan" => $request->assign_default_plan,
                    "alert_message"       => $request->alert_message,
                    "expire_message"      => $request->expire_message,
               ];
            }
            else{
                 $data = [
                    "order_complete"      => $request->order_complete,
                    "user_balance_low"    => $request->user_balance_low,
                    
               ];
            }
            
            $value = json_encode($data);
            $option->value = $value;
            $option->save();

            return response()->json('Cron Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
