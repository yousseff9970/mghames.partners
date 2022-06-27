<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class AdminController extends Controller
{
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        abort_if(!getpermission('admins'),401);
        $users = User::where('role_id',3)->where('id','!=',1)->latest()->get();
        return view('seller.admin.index', compact('users'));
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!getpermission('admins'),401);
      
        $roles  = User::$seller_roles;
        return view('seller.admin.create', compact('roles'));
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        abort_if(!getpermission('admins'),401);
        
        $max_users=(int)tenant('staff_limit');

         $admin=User::where('role_id',3)->count();
         $sellers=User::where('role_id',5)->count();
         $total_staff=$admin+$sellers;

         if ($max_users <= $total_staff) {
               $errors['errors']['error']='Maximum Staff Limit exceeded';
               return response()->json($errors,401);
         }
         
        // Validation Data
        $request->validate([
            'name' => 'required|max:50',
            'roles' => 'required',
            'email' => 'required|max:100|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'roles'=>'required'
        ]);

        // Create New User
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = 3;
        $user->password = Hash::make($request->password);
        $user->permissions=json_encode($request->roles);
        $user->save();

        


        return response()->json(['User has been created !!']);
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
       abort_if(!getpermission('admins'),401);

        $user = User::where('role_id',3)->findOrFail($id);
        $roles  = User::$seller_roles;

        return view('seller.admin.edit', compact('user', 'roles'));
        
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
        abort_if(!getpermission('admins'),401);
        // Create New User
        $user = User::where('role_id',3)->findOrFail($id);

        // Validation Data
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|max:100|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6|confirmed',
        ]);


        $user->name = $request->name;
        $user->email = $request->email;
        $user->status = $request->status;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->permissions=json_encode($request->roles);
        $user->save();

        


        return response()->json(['User has been updated !!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
       abort_if(!getpermission('admins'),401);
       
                if (count($request->ids ?? []) == 0) {
                    return response()->json('Success');
                }
                if ($request->status == 'delete') {
                    if ($request->ids) {
                       
                        User::where('role_id',3)->whereIn('id',$request->ids)->delete();
                    }
                }
                else{
                   
                    if ($request->ids) {
                        
                        User::where('role_id',3)->whereIn('id',$request->ids)->update(['status'=>$request->status]);
                    }
                }
            
        

        return response()->json('Success');
    }
}
