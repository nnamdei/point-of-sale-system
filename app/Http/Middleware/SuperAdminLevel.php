<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class SuperAdminLevel
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
        if(Auth::check() && Auth::user()->isSuperAdmin()){
            return $next($request);
        }
        else{
            return redirect()->back()->with('info', 'Not authorized!');
        }

    }
}
