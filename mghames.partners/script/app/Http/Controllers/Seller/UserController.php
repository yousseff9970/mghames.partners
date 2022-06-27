<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Hash;
use Auth;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(tenant('customer_modules') != 'on',404);
        abort_if(!getpermission('users'),401);
        $users= User::where('role_id',4)->latest();
        if (isset($request->src)) {
          $users=  $users->where('email','LIKE','%'.$request->src.'%');
        }
        $users=$users->paginate(30);

        return view('seller.user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(tenant('customer_modules') != 'on',404);
       abort_if(!getpermission('users'),401);
        return view('seller.user.create');
    }

    public function login($id)
    {
        abort_if(tenant('customer_modules') != 'on',404);
       abort_if(!getpermission('users'),401);
        $user=User::where('status',1)->where('role_id','!=',3)->findorFail($id);
        Auth::logout();
        Auth::loginUsingId($id);

        if ($user->role_id == 5) {
            return redirect('/rider/dashboard');
        }
        return redirect('/login');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(tenant('customer_modules') != 'on',404);
       abort_if(!getpermission('users'),401);
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'status' => 'required'
        ]);

        $user = new User();
        $user->role_id = 4;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->status = $request->status;
        $user->save();

        return response()->json('User Created');
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         abort_if(tenant('customer_modules') != 'on',404);
       abort_if(!getpermission('users'),401);
        $user = User::find($id);
        return view('seller.user.edit',compact('user'));
    }

    public function show($id)
    {
       abort_if(!getpermission('users'),401);
        $user = User::with('user_orders')->where([
           
            ['id',$id]
        ])->first();

        $completed_orders = $user->user_orders()->where('status_id',1)->count();
        $pending_orders = $user->user_orders()->where('status_id',3)->count();
        $cancalled_orders = $user->user_orders()->where('status_id',2)->count();

        

        return view('seller.user.profile',compact('user','completed_orders','pending_orders','cancalled_orders'));
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
         abort_if(tenant('customer_modules') != 'on',404);
       abort_if(!getpermission('users'),401);
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'status' => 'required'
        ]);


       
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->password)
        {
            $request->validate([
                'password' => 'required|confirmed'
            ]);
            $user->password = $request->password;
        }
        $user->status = $request->status;
        $user->save();

        return response()->json('User Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(tenant('customer_modules') != 'on',404);
       abort_if(!getpermission('users'),401);
        User::query()->where('id',$id)->delete();
        
        return back();
    }
}
