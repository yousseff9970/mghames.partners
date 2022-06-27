<?php

namespace App\Http\Controllers\Admin;

use App\Models\Getway;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\DB;
use Storage;
class PaymentGatewayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
       
        abort_if(!Auth()->user()->can('getway.index'), 401);
        $gateways = Getway::all();
        return view('admin.gateway.index', compact('gateways'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
         abort_if(!Auth()->user()->can('getway.index'), 401);
        return view('admin.gateway.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|unique:getways,name',
            'logo'            => 'nullable|mimes:jpeg,png,jpg,svg,gif|max:100',
            'rate'            => 'required',
            'charge'          => 'required',
            'currency_name'   => 'required',
        ]);

        $gateway = new Getway;

        if ($request->hasFile('logo')) {
            
            
            $image=$request->file('logo');
            $path='uploads/'.strtolower(env('APP_NAME')).date('/y/m/');
            $name = uniqid().date('dmy').time(). "." . strtolower($image->getClientOriginalExtension());

            Storage::disk(env('STORAGE_TYPE'))->put($path.$name, file_get_contents(Request()->file('logo')));

            $file_url= Storage::disk(env('STORAGE_TYPE'))->url($path.$name);
            $gateway->logo=$file_url;
        }

        $gateway->name = $request->name;
        $gateway->rate = $request->rate;
        $gateway->charge = $request->charge;
        $gateway->namespace = 'App\Lib\CustomGetway';
        $gateway->currency_name = $request->currency_name;
        $gateway->is_auto = 0;
        $gateway->image_accept = $request->image_accept;
        $gateway->status= $request->status;
        $gateway->data= $request->instruction;
        $gateway->save();

        return response()->json('Successfully Created!');
    }




    /**
     * Display the specified resource.
     *
     * @param PaymentGateway $paymentGateway
     * @return Response
     */
    public function show(PaymentGateway $paymentGateway): Response
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
        abort_if(!Auth()->user()->can('getway.edit'), 401);
        $gateway = Getway::findOrFail($id);
        return view('admin.gateway.edit', compact('gateway'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'            => 'required|unique:getways,name,' . $id,
            'logo'            => 'nullable|mimes:jpeg,png,jpg,svg,gif|max:100',
            'rate'            => 'required',
            'charge'          => 'required',
            'namespace'       => 'nullable',
            'currency_name'   => 'required',
        ]);

        $gateway = Getway::findOrFail($id);
        if ($gateway->is_auto == 0) {
             $request->validate([
                'payment_instruction'   => 'required',
             ]);
             $gateway->data = $request->payment_instruction;
        }
        else{
            $gateway->data = $request->data ? json_encode($request->data) : '';
        }
        if ($request->hasFile('logo')) {
            if (!empty($gateway->logo)) {
                $file=$gateway->logo;
                $arr=explode('uploads',$file);
                if (count($arr ?? []) != 0) {
                    if (isset($arr[1])) {
                       Storage::disk(env('STORAGE_TYPE'))->delete('uploads'.$arr[1]);
                    }
                }
            }
            
            $image=$request->file('logo');
            $path='uploads/'.strtolower(env('APP_NAME')).date('/y/m/');
            $name = uniqid().date('dmy').time(). "." . strtolower($image->getClientOriginalExtension());

            Storage::disk(env('STORAGE_TYPE'))->put($path.$name, file_get_contents(Request()->file('logo')));

            $file_url= Storage::disk(env('STORAGE_TYPE'))->url($path.$name);
            $gateway->logo=$file_url;

            
        }

        $gateway->name = $request->name;
        $gateway->rate = $request->rate;
        $gateway->charge = $request->charge;
        $gateway->currency_name = strtoupper($request->currency_name);
        $gateway->test_mode = $request->test_mode;
        $gateway->status= $request->status;
        $gateway->image_accept = $request->image_accept;
        $gateway->save();

        return response()->json('Successfully Updated!');
    }

   
  
}
