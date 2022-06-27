<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = Auth::user()->id;
        $data = Order::with('getway', 'user','plan')->where('user_id', $id);
        if ($request->start_date || $request->end_date) {
            $start_date = $request->start_date . " 00:00:00";
            $end_date = $request->end_date . " 23:59:59";
            if ($request->start_date == '' && $request->end_date == '') {
                $data = $data->paginate(10);
            } elseif ($request->start_date == '' && $request->end_date != '') {
                $data = $data->where('created_at', '<', $request->end_date)->paginate(10);
            } elseif ($request->start_date != '' && $request->end_date == '') {
                $data = $data->where('created_at', '>', $request->start_date)->paginate(10);
            } else {
                $data = $data->whereBetween('created_at', [$start_date, $end_date])->paginate(10);
            }

        } elseif ($request->type == 'getway_name') {
            $q = $request->value;
            $data = $data->whereHas('getway', function ($query) use ($q) {
                return $query->where('name', 'LIKE', "%$q%");
            })->paginate(10);
           
        } elseif ($request->type == 'trx') {
            $q = $request->value;
            $data = $data->where('trx', 'LIKE', "%$q%")->paginate(10);
            
        }elseif ($request->type == 'plan') {
            $q = $request->value;
            $data = $data->whereHas('plan', function ($query) use ($q) {
                return $query->where('name', 'LIKE', "%$q%");
            })->paginate(10);
           
        } elseif ($request->type == 'price') {
            $q = $request->value;
            $data = $data->where('price', 'LIKE', "%$q%")->paginate(10);
            
        } 

        $data = $data->latest()->paginate(15);
        return view('merchant.report.index', compact('data'));
    }

    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Order::with('getway', 'user','plan','ordermeta')->where('user_id',Auth::id())->findOrFail($id);
        
        return view('merchant.report.show', compact('data'));
    }

    

}
