<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class MerchantMiddleware
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
        if (Auth::user() &&  Auth::user()->role_id == 2) {
            if (str_replace('www.', '', $request->getHost()) != env('APP_PROTOCOLESS_URL')) {
                Auth::logout();
                abort(404);
            }
            if (Auth::user()->status == 1) {
               return $next($request);
            }

            return redirect('/');
            
            
        }
        return abort(403);
    }
}
