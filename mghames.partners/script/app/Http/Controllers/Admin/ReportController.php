<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ReportExport;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class ReportController extends Controller
{
    public function excel(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return Excel::download(new ReportExport(), 'order-report.xlsx');
    }

    public function csv()
    {
        return (new ReportExport)->download('order-report.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function pdf(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return (new ReportExport)->download('order-report.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }

    public function invoicePdf($id)
    {
        $data = Order::with('plan', 'getway', 'user')->findOrFail($id);
        $pdf = PDF::loadView('admin.report.invoice-pdf', compact('data'));
        return $pdf->download('order-invoice.pdf');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(!Auth()->user()->can('report'), 401);
        $total_orders = Order::count('id');
        $total_earning = Order::sum('price');
        $total_pending = Order::where('status', 2)->count('id');
        $total_expired = Order::where('status', 3)->count('id');
        if ($request->start_date || $request->end_date) {
            $start_date = $request->start_date . " 00:00:00";
            $end_date = $request->end_date . " 23:59:59";
            $data = Order::with('plan', 'getway', 'user','tenant');
            if ($request->start_date == '' && $request->end_date == '') {
                $data = $data->latest()->paginate(10);
            } elseif ($request->start_date == '' && $request->end_date != '') {
                $data = $data->where('created_at', '<', $request->end_date)->latest()->paginate(10);
            } elseif ($request->start_date != '' && $request->end_date == '') {
                $data = $data->where('created_at', '>', $request->start_date)->latest()->paginate(10);
            } else {
                $data = $data->whereBetween('created_at', [$start_date, $end_date])->latest()->paginate(10);
            }
        } elseif ($request->select_day) {
            if ($request->select_day == 'today') {
                $data = Order::with('plan', 'getway', 'user','tenant')->whereBetween('created_at', [Carbon::now()->setTime(0, 0)->format('Y-m-d H:i:s'), Carbon::now()->setTime(23, 59, 59)->format('Y-m-d H:i:s')])->latest()->paginate(10);
            } elseif ($request->select_day == 'thisWeek') {
                $data = Order::with('plan', 'getway', 'user','tenant')->whereBetween('created_at', [Carbon::now()->startOfWeek()->setTime(0, 0)->format('Y-m-d H:i:s'), Carbon::now()->endOfWeek()->setTime(23, 59, 59)->format('Y-m-d H:i:s')])->latest()->paginate(10);
            } elseif ($request->select_day == 'thisMonth') {
                $data = Order::with('plan', 'getway', 'user','tenant')->whereBetween('created_at', [Carbon::now()->firstOfMonth()->setTime(0, 0)->format('Y-m-d H:i:s'), Carbon::now()->endOfMonth()->setTime(23, 59, 59)->format('Y-m-d H:i:s')])->latest()->paginate(10);
            } elseif ($request->select_day == 'thisYear') {
                $data = Order::with('plan', 'getway', 'user','tenant')->whereBetween('created_at', [Carbon::now()->startOfYear()->setTime(0, 0)->format('Y-m-d H:i:s'), Carbon::now()->endOfYear()->setTime(23, 59, 59)->format('Y-m-d H:i:s')])->latest()->paginate(10);
            }
        } elseif ($request->type == 'customer_name') {
            $q = $request->value;
            $data = Order::with('plan', 'getway', 'user','tenant')->whereHas('user', function ($query) use ($q) {
                return $query->where('name', 'LIKE', "%$q%");
            })->latest()->paginate(10);

        } elseif ($request->type == 'plan_name') {
            $q = $request->value;
            $data = Order::with('plan', 'getway', 'user','tenant')->whereHas('plan', function ($query) use ($q) {
                return $query->where('name', 'LIKE', "%$q%");
            })->latest()->paginate(10);
        } elseif ($request->type == 'getway_name') {
            $q = $request->value;
            $data = Order::with('plan', 'getway', 'user','tenant')->whereHas('getway', function ($query) use ($q) {
                return $query->where('name', 'LIKE', "%$q%");
            })->latest()->paginate(10);
        } elseif ($request->type == 'exp_date') {
            $q = $request->value;
            $data = Order::with('plan', 'getway', 'user','tenant')->where('exp_date', 'LIKE', "%$q%")->latest()->paginate(10);
        } elseif ($request->type == 'trx') {
            $q = $request->value;
            $data = Order::with('plan', 'getway', 'user','tenant')->where('trx', 'LIKE', "%$q%")->latest()->paginate(10);
        } else {
            $data = Order::with('plan', 'getway', 'user','tenant')->latest()->paginate(10);
        }

        return view('admin.report.index', compact('data','total_orders','total_earning','total_pending','total_expired'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Order::with('plan', 'getway', 'user','tenant')->findOrFail($id);
        return view('admin.report.show', compact('data'));
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
