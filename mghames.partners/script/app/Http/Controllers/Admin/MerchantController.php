<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MerchantRequest;
use App\Jobs\SendEmailJob;
use App\Mail\MerchantMail;
use App\Models\Plan;
use App\Models\User;
use App\Models\Userplan;
use App\Models\Order;
use App\Models\Tenant;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Auth;
class MerchantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|View|Response
     */
    public function index(Request $request)
    {
        abort_if(!Auth()->user()->can('merchant.index'), 401);
        $user = User::where('role_id', '2');
        $active = $user->where('status', '1')->count();
        $inactive = $user->where('status', '0')->count();
        $all = User::where('role_id', '2')->count();
        if ($request->has('1') || $request->has('0')) {
            if ($request->has('1')) {
                $data = User::where('role_id', '2')->where('status', '1')->withCount('tenant')->withCount('orders')->latest();
            } else {
                $data = User::where('role_id', '2')->where('status', '0')->withCount('tenant')->withCount('orders')->latest();
            }
        } else {
            $data = User::where('role_id', '2')->withCount('tenant')->withCount('orders')->latest();
        }

        if (!empty($request->src)) {
           $data=$data->where($request->type,'LIKE','%'.$request->src.'%');
        }

        $data=$data->paginate(20);
        return view('admin.merchant.index', compact('data', 'active', 'inactive', 'all','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        abort_if(!Auth()->user()->can('merchant.create'), 401);
        return view('admin.merchant.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MerchantRequest $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|max:100|email|unique:users',
            'password' => 'required|min:6',
        ]);

        DB::beginTransaction();
        try {
            //write your code here
            $obj = new User();
          
            $obj->password = Hash::make($request->password);
            $obj->name = $request->name;
            $obj->email = $request->email;
            $obj->status = isset($request->status) ? $request->status : 1;
            $obj->role_id = 2;
            $obj->save();
           
            DB::commit();
            return response()->json('Partner Created Successfully');
        } catch (Exception $e) {
            DB::rollback();
        }

        return response()->json('Error Occured');
        

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
         abort_if(!Auth()->user()->can('merchant.edit'), 401);
        $data = User::withCount('tenant','orders','supports','active_orders')->withSum('orders','price')->where('role_id',2)->findOrFail($id);
        $orders = Order::with('plan', 'getway','orderlog')->where('user_id',$id)->latest()->paginate(30);
        $tenants=Tenant::where('user_id',$id)->withCount('domains')->latest()->get();
        return view('admin.merchant.show', compact('data','orders','tenants'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View|Response
     */
    public function edit($id)
    {
        abort_if(!Auth()->user()->can('merchant.edit'), 401);
        $data = User::where('role_id',2)->findOrFail($id);
        return view('admin.merchant.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {   

        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|max:100|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
        ]);

        $obj = User::findOrFail($id);
        $obj->name=$request->name;
        $obj->email=$request->email;
        if ($request->password) {
            $obj->password=Hash::make($request->password);
        }
        $obj->amount=$request->amount;
        $obj->status = $request->status;
        $success = $obj->save();
        if ($success) {
            return response()->json('Partner Info Updated Successfully');
        } else {
            return response()->json('System Error');
        }
    }

    public function login($id)
    {
        abort_if(!Auth()->user()->can('merchant.edit'), 401);
        Auth::logout();
        Auth::loginUsingId($id);

        return redirect('/login');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        abort_if(!Auth()->user()->can('merchant.delete'), 401);
        $data = User::findOrFail($id);
        if (file_exists($data->image)) {
            unlink($data->image);
        }
        $data->delete();
        return redirect()->back()->with('success', 'Merchant Deleted Successfully');
    }

    public function sendMail($id, Request $request)
    {
        abort_if(!Auth()->user()->can('merchant.mail'), 401);
        $user = User::findOrFail($id);
        $data = [
            'email'   => $user->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'type'    => 'usermail',
        ];
        if (env('QUEUE_MAIL') == 'on') {
            dispatch(new SendEmailJob($data));
        } else {
            Mail::to($user->email)->send(new MerchantMail($data));
        }

        return response()->json('Email Sent Successfully !');
    }


    function uniqkeyuser($column){  
        $str = Str::random(16);
        $check = User::where($column, $str)->first();
        if($check == true){
            $str = $this->uniqkeyuser($column);
        }
        return $str;
    }
}
