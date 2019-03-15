<?php

namespace App\Http\Middleware;

use Closure;

class DisableSales
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
        return redirect()->back()->with('warning',"Sales is currently disabled");
        //return $next($request);
    }
}
