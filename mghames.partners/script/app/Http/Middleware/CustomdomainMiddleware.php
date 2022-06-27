<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;
class CustomdomainMiddleware
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
       
        if (tenant('will_expire') >= Carbon::today() && tenant('status') == 1) {
            if (get_planinfo('custom_domain') == 'on') {
                return $next($request);
            }

            return redirect('/oops');
            
        }
        return redirect(env('APP_URL'));
       
    }
}
