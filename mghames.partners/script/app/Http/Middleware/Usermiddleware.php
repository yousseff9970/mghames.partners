<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
class Usermiddleware
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
        if (Auth::user() &&  Auth::user()->status == 1) {
            return $next($request);
        }
        else{
           \Session::flash('error','Opps your account is disabled please contact with support');

           Auth::logout();
           return redirect('/login');
        }
        
    }
}
