<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class ManagerOnly
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
        if(Auth::check() && Auth::user()->isManager()){
            return $next($request);
        }
        return redirect()->back()->with('info', 'Only a manager is priviledged for that');
    }
}
