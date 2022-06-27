<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
class SellerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
         if (Auth::check() && Auth::User()->role_id == 3) {
            if (Auth::user()->status != 1) {
                \Session::flash('error','Opps your account is disabled please contact with support');
                Auth::logout();
                return redirect()->route('login');
            }
            return $next($request);
           
        }else{
            return redirect()->route('login');
        } 
    }
}
