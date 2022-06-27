<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
         $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if(Auth::check() && Auth::user()->role_id == 1) {
                    return redirect()->route('admin.dashboard');
                } 
                elseif(Auth::check() && Auth::User()->role_id == 2) {

                    return redirect()->route('merchant.dashboard');
                    
                }elseif(Auth::check() && Auth::User()->role_id == 3) {
                    return redirect('/seller/dashboard');
                }elseif(Auth::check() && Auth::User()->role_id == 4)
                {
                    return redirect('/customer/dashboard');
                }
                elseif(Auth::check() && Auth::User()->role_id == 5) {
                    return redirect('/rider/dashboard');
                }
                else {
                    return redirect()->route('login');
                }
            }
        }

        return $next($request);
    }
}
