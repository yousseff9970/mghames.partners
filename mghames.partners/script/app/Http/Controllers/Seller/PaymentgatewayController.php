<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Getway;
use Illuminate\Http\Request;
use Paymentgateway;
use Auth;
class PaymentgatewayController extends Controller
{
    public function index()
    {
        abort_if(!getpermission('payment_gateway'),401);
        abort_if(!file_exists(app_path('Lib/gateways.json')),404);

        $payments_gateways=file_get_contents(app_path('Lib/gateways.json'));
        $payments_gateways=json_decode($payments_gateways);
        $installed_payments = Getway::latest()->get();

        $namespaces=[];

        foreach ($installed_payments as $key => $row) {
           array_push($namespaces,$row->namespace);
        }

        


       
        return view('seller.paymentgateway.index',compact('payments_gateways','installed_payments','namespaces'));
    }

    public function payment_edit($payment)
    {
        abort_if(!getpermission('payment_gateway'),401);
        $gateway = Getway::findOrFail($payment);
        return view('seller.paymentgateway.edit',compact('gateway'));
    }


    public function install($payment)
    {
        abort_if(!getpermission('payment_gateway'),401);
        $gateway_data = json_decode(file_get_contents(app_path('Lib/gateways.json')));

        foreach ($gateway_data as $key => $value) {
            if($value->name == $payment)
            {
                $gateway = $value;
            }
        }
        
        
        $getway = new Getway();
        $getway->name = $gateway->name;
        $getway->logo = $gateway->logo;
        $getway->namespace = $gateway->namespace;
        $getway->phone_required = $gateway->phone_required;
        $getway->currency_name = $gateway->currency_name;
        $getway->status = 1;
        $getway->is_auto = $gateway->is_auto ?? 0;
        $getway->test_mode = 0;
        $getway->data = json_encode($gateway->data ?? '');
        $getway->save();

        

        return redirect()->route('seller.payment.edit',$getway->id);

    }


    public function store(Request $request,$id)
    {
       abort_if(!getpermission('payment_gateway'),401);
        $request->validate([
            'name' => 'required|max:255',
            'rate' => 'required|numeric',
            'charge' => 'required|numeric',
            'currency_name' => 'required|max:10'
        ]);

        $gateway = Getway::findOrFail($id);
        $gateway->logo = $request->preview;
        $gateway->name = $request->name;
        $gateway->rate = $request->rate;
        $gateway->charge = $request->charge;
        $gateway->currency_name = $request->currency_name;
        $gateway->instruction = $request->instruction;
        $gateway->status = $request->status ?? 0;
        $gateway->test_mode = $request->test_mode ?? 0;
        $gateway->data = json_encode($request->data);

      
        $gateway->save();

        return response()->json('Successfully Updated');

    }

    public function custom_payment_create()
    {
        abort_if(!getpermission('payment_gateway'),401);
        return view('seller.paymentgateway.create');
    }

    public function custom_payment(Request $request)
    {
        abort_if(!getpermission('payment_gateway'),401);

        $request->validate([
            'name' => 'required|max:255',
            'rate' => 'required|numeric',
            'charge' => 'required|numeric',
            'currency_name' => 'required|max:10'
        ]);

        $gateway = new Getway();
        $gateway->logo = $request->preview;
        $gateway->namespace = 'App\Lib\CustomGetway';
        $gateway->name = $request->name;
        $gateway->rate = $request->rate;
        $gateway->charge = $request->charge;
        $gateway->currency_name = $request->currency_name;
        $gateway->instruction = $request->instruction;
        $gateway->status = $request->status ?? 0;
        $gateway->test_mode = $request->test_mode ?? 0;
        $gateway->save();

        return response()->json('Successfully Created');
    }
}
