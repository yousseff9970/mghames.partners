<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::User()->role_id == 1) {
            
            if (str_replace('www.', '', $request->getHost()) != env('APP_PROTOCOLESS_URL')) {
                Auth::logout();
                abort(404);
            }
            if (Auth::user()->status != 1) {
                Auth::logout();
                return redirect()->route('login');
            }
            return $next($request);
           
        }else{
            return redirect()->route('login');
        } 
    }
}
