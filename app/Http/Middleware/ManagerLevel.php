<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class ManagerLevel
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
        if(Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isManager())){
            return $next($request);
        }
        else{
            return redirect()->back()->with('info',"You must be at least a manager for that priviledge");
        }
    }
}
