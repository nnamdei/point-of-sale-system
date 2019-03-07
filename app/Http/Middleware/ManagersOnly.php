<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class ManagersOnly
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
        if(Auth::guest() || !Auth::user()->isManager()){
         return   redirect()->back()->with('info',"Sorry <strong>".Auth::user()->firstname."</strong>, You do not have access to that resource");
        }
        return $next($request);
    }
}
