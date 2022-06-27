<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ordershipping;
use Hash;
use Auth;
class RiderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         abort_if(!getpermission('rider'),401);
        $users= User::where('role_id',5)->latest();
        if (isset($request->src)) {
          $users=  $users->where('email','LIKE','%'.$request->src.'%');
        }
        $users=$users->paginate(30);

        return view('seller.rider.index',compact('users','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
          abort_if(!getpermission('rider'),401);
        return view('seller.rider.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
           abort_if(!getpermission('rider'),401);

         $max_users=(int)tenant('staff_limit');

         $admin=User::where('role_id',3)->count();
         $sellers=User::where('role_id',5)->count();
         $total_staff=$admin+$sellers;

         if ($max_users <= $total_staff) {
               $errors['errors']['error']='Maximum Staff Limit exceeded';
               return response()->json($errors,401);
         }

        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'status' => 'required'
        ]);

        $user = new User();
        $user->role_id = 5;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->status = $request->status;
        $user->save();

        return response()->json('Rider Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
          abort_if(!getpermission('rider'),401);
        $rider = User::with('rider_orders')->where([
            ['id',$id],
            ['role_id',5]
        ])->first();

        $completed_orders = $rider->rider_orders()->where('status_id',1)->count();
        $pending_orders = $rider->rider_orders()->where('status_id',3)->count();
        $cancalled_orders = $rider->rider_orders()->where('status_id',2)->count();

        if(!$rider)
        {
            return abort('404');
        }

       $orders=Ordershipping::whereHas('order')->with('order')->where('user_id',$id)->orderBy('id','DESC')->paginate(20);
        return view('seller.rider.profile',compact('rider','completed_orders','pending_orders','cancalled_orders','orders'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
          abort_if(!getpermission('rider'),401);
        $user = User::find($id);
        return view('seller.rider.edit',compact('user'));
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
          abort_if(!getpermission('rider'),401);
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
            $user->password = \Hash::make($request->password);
        }
        $user->status = $request->status;
        $user->save();

        return response()->json('Rider Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
          abort_if(!getpermission('rider'),401);
        User::query()->where('id',$id)->delete();

        return back();
    }
}
