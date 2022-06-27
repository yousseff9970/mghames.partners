<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Getway;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
class FundController extends Controller
{
    public function history(Request $request)
    {
        abort_if(!Auth()->user()->can('fund'),401);
        if($request->data == 1)
        {
            $funds = Deposit::with('user')->latest()->paginate(20);
            $status = 'active';
        }elseif($request->data == 2)
        {
            $funds = Deposit::with('user')->where('status',2)->latest()->paginate(20);
            $status = 'pending';
        }elseif($request->data == 3)
        {
            $funds = Deposit::with('user')->where('status',3)->latest()->paginate(20);
            $status = 'expired';
        }elseif($request->data == 0){
            $funds = Deposit::with('user')->where('status',0)->latest()->paginate(20);
            $status = 'failed';
        }

        $all_deposits_count = Deposit::count();
        $pending_deposits_count = Deposit::where('status',2)->count();
        $expired_deposits_count = Deposit::where('status',3)->count();
        $failed_deposits_count = Deposit::where('status',0)->count();

        $gateways = Getway::where('status',1)->get();

        return view('admin.fund.history',compact('funds','status','all_deposits_count','pending_deposits_count','expired_deposits_count','failed_deposits_count','gateways','request'));
    }

    public function approved(Request $request)
    {
        abort_if(!Auth()->user()->can('fund'),401);
        
        if($request->multi_id)
        {
            if($request->status == 5)
            {
                foreach ($request->multi_id as $key => $value) {
                    $deposit = Deposit::find($value);
                    $deposit->delete();
                }
            }else{
                foreach ($request->multi_id as $key => $value) {
                    $deposit = Deposit::find($value);
                    $deposit->payment_status = $request->status;
                    $deposit->status = $request->status;
                    $deposit->save();
                }
            }
            
        }elseif($request->id)
        {
            $deposit = Deposit::find($request->id);
            $deposit->payment_status = 1;
            $deposit->status = 1;
            $deposit->save();

            $user=User::findorFail($deposit->user_id);
            $user->amount=$user->amount+$deposit->amount;
            $user->save();
        }else{
            $error['errors']['domain']='Opps! Please select any row.';
    		return response()->json($error,422);
        }

        if($request->status == 5)
        {
            return response()->json('Fund Approved!');
        }elseif($request->status == 2)
        {
            return response()->json('Fund Move To Pending!');
        }else{
            return response()->json('Fund Approved!');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'trx_id' => 'required|max:255',
            'email' => 'required',
            'gateway' => 'required',
            'amount' => 'required'
        ]);

        $user = User::where('email',$request->email)->first();
        if(!$user)
        {
            $error['errors']['domain']="User doesn't exists!";
    		return response()->json($error,422);
        }

        $trx = Deposit::where('trx',$request->trx)->first();

        if($trx)
        {
            $error['errors']['domain']="Trx id already exists!";
    		return response()->json($error,422);
        }

        $deposit = new Deposit();
        $deposit->trx = $request->trx_id;
        $deposit->user_id = $user->id;
        $deposit->gateway_id = $request->gateway;
        $deposit->type = 1;
        $deposit->amount = $request->amount;
        $deposit->status = 1;
        $deposit->payment_status = 1;
        $deposit->save();

        $user->amount = $user->amount + $request->amount;
        $user->save();

        return response()->json('Fund Created');

    }
}
