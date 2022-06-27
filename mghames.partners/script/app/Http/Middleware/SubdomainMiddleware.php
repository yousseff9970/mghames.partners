<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;
class SubdomainMiddleware
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
            if (get_planinfo('sub_domain') == 'on') {
                return $next($request);
            }

           die('Opps this domain not available');
            
        }
        return redirect(env('APP_URL'));
    }
}
