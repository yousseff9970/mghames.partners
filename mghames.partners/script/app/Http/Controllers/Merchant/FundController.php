<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use Illuminate\Http\Request;
use Session;
use App\Models\Getway;
use App\Models\Option;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Storage;
class FundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('merchant.fund.index');
    }

    public function history(Request $request)
    {
        if($request->start_date && $request->end_date)
        {
            $start_date = Carbon::parse($request->start_date);
            $end_date = Carbon::parse($request->end_date);
            $funds = Deposit::whereBetween('created_at',[$start_date,$end_date])->where('user_id',Auth::User()->id)->latest()->paginate(20);
        }elseif($request->value)
        {
            $search = $request->value;
            $funds = Deposit::where([
                ['user_id',Auth::User()->id],
                ['trx', 'LIKE', "%$search%"]
            ])->latest()->paginate(20);
        }else{
            $funds = Deposit::where('user_id',Auth::User()->id)->latest()->paginate(20);
        }
        return view('merchant.fund.history',compact('funds'));
    }

    public function payment()
    {
        abort_if(!Session::has('deposit_amount'),403);

        $gateways = Getway::where('status', 1)->where('name','!=', 'free')->where('id','!=',14)->get(); 
        $tax = Option::where('key','tax')->first();
        return view('merchant.fund.gateway',compact('gateways','tax'));
        
    }

    public function deposit(Request $request){   
        
        $gateway = Getway::findOrFail($request->id);
        if($gateway->phone_required == 1){ 
            $request->validate([
                'phone' => 'required',
            ],
            [
                'phone.required' => 'Phone number is required for : ' . ucwords($gateway->name),
            ]
        );
            
        }
     
        if ($gateway->is_auto == 0 ) {
               $request->validate([
                'screenshot' => 'required|image|max:800',
                'comment' => 'required|max:200'
                ]);


                
             

             $image=$request->file('screenshot');
             $path='uploads/'.strtolower(env('APP_NAME')).'/payments'.date('/y/m/');
             $name = uniqid().date('dmy').time(). "." . strtolower($image->getClientOriginalExtension());

             Storage::disk(env('STORAGE_TYPE'))->put($path.$name, file_get_contents(Request()->file('screenshot')));

             $image= Storage::disk(env('STORAGE_TYPE'))->url($path.$name);
             $payment_data['screenshot'] =$image;
             $payment_data['comment'] =$request->comment;
        }
        $gateway_info = json_decode($gateway->data); //for creds
        $tax = Option::where('key','tax')->first();

        $payment_data['currency'] = $gateway->currency_name ?? 'USD';
        $payment_data['email'] = Auth::user()->email;
        $payment_data['name'] = Auth::user()->name;
        $payment_data['phone'] = $request->phone;
        $payment_data['billName'] = 'Add Money In Account';
        $payment_data['amount'] = Session::get('deposit_amount');
        $payment_data['test_mode'] = $gateway->test_mode;
        $payment_data['charge'] = $gateway->charge ?? 0;
        $payment_data['pay_amount'] = (Session::get('deposit_amount') * $gateway->rate) + $gateway->charge;
        $payment_data['getway_id'] = $gateway->id;
        $payment_data['payment_type'] = 'deposit_fund';
        $payment_data['request'] = $request->except('_token');
        $payment_data['request_from'] = 'merchant';
        

        if (!empty($gateway_info)) {
            foreach ($gateway_info as $key => $info) {
                $payment_data[$key] = $info;
            };
        }
        Session::forget('fund_callback');

        Session::put('fund_callback',[
            'success_url' => 'partner/fund/redirect/success',
            'cancel_url' => 'partner/fund/redirect/fail'
        ]);

       return  $gateway->namespace::make_payment($payment_data);       
    }

    public function success()
    {
        abort_if(!Session::has('deposit_amount'),404);
        abort_if(!Session::has('fund_callback'),404);
        abort_if(!Session::has('payment_info'),404);
       

        $deposit = new Deposit();
        $deposit->user_id = Auth::User()->id;
        $deposit->gateway_id = Session::get('payment_info')['getway_id'];
        $deposit->trx = Session::get('payment_info')['payment_id'];
        $deposit->amount = Session::get('payment_info')['amount'];
        $deposit->status = Session::get('payment_info')['status'];
        $deposit->payment_status = Session::get('payment_info')['payment_status'];
        if (isset(Session::get('payment_info')['meta'])) {
            $deposit->type = 0;
            $deposit->meta = json_encode(Session::get('payment_info')['meta'] ?? '');
        }
       
        $deposit->save();

        $payment_info = Session::get('payment_info');

        $user = User::find(Auth::User()->id);
        if($payment_info['payment_method'] == 'manual')
        {
            $user->amount = $user->amount;
        }else{
            $user->amount = $user->amount + Session::get('payment_info')['amount'];
        }
        $user->save();

        Session::forget('deposit_amount');
        Session::forget('fund_callback');
        Session::forget('payment_info');

        Session::flash('message', 'Transaction Successfully Complete!');
        Session::flash('type', 'success');

        return view('merchant.fund.success',compact('payment_info'));
    }


    public function fail()
    {
        Session::forget('deposit_amount');
        Session::forget('fund_callback');
        Session::forget('payment_info');

        Session::flash('message', 'Transaction Filed!');
        Session::flash('type', 'danger');

        return redirect()->route('merchant.fund.index');
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
        $request->validate([
            'amount' => 'required|numeric',
            'agree' => 'required',
        ]);

        Session::put('deposit_amount',$request->amount);

        return response()->json('Great! Now, You will Redirect To Next Step');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fund = Deposit::find($id);
        return view('merchant.fund.view',compact('fund'));
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
        //
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
