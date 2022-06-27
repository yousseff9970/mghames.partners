<?php

namespace App\Http\Controllers\Rider;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Hash;

class SettingsController extends Controller
{
    public function index()
    {
        return view('rider.settings.index');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);

        $user = User::where('id',Auth::User()->id)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        
        if($request->password)
        {
            $request->validate([
                'current_password' => 'required|password',
                'password' => 'required|confirmed',
            ]);

            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json('Profile Updated');


    }
}
