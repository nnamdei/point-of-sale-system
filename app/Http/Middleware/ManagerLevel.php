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
        if(Auth::guest() || Auth::user()->isAdmin() || Auth::user()->isManager()){
   
        }
        else{
            return   redirect()->back()->with('info',"only managers and admin are allowed for that");
        }
        return $next($request);
    }
}
