<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use App\Models\Tenant;

class LoginController extends Controller
{
    public function login(Request $request)
    {

        $user = User::where([
            ['email',$request->email]
        ])->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user,true);

            return redirect()->route('login');
        }else{
            return redirect()->route('login');
        }
        
    }

    public function tokenBasedLogin($token)
    {
        $token=request()->route()->parameter('token');
        if (tenant('auth_token') == null) {
            abort(404);
        }
        try {
            $token = Crypt::decryptString($token);
            if (tenant('auth_token') == $token) {
                $tenant=Tenant::where('status',1)->where('will_expire','>',now())->findorfail(tenant('id'));
                $tenant->auth_token=null;
                $tenant->save();
                $user=User::first();
                Auth::loginUsingId($user->id);
                return redirect('/login');
            }
        } catch (DecryptException $e) {
          abort(404);
        }
        abort(404);
    }
}
