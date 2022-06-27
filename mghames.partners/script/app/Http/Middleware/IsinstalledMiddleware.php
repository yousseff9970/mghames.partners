<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsinstalledMiddleware
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
        if(env('DB_DATABASE') != null){
            return $next($request);
        }else{
            return redirect('/install');
        }
        
    }
}
