<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class AttendantLevel
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

        if(Auth::guest() || Auth::user()->isAdmin() || Auth::user()->isManager() || Auth::user()->isAttendant()){
           
        }else{
            return redirect()->back()->with('info',"only attendant is authorized for that");
        }
        return $next($request);
    }
}
