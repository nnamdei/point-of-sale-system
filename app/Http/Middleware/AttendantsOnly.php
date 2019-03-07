<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class AttendantsOnly
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
        if(Auth::guest() || !Auth::user()->isAttendant()){
           return redirect()->back()->with('info',"Sorry <strong>".Auth::user()->firstname."</strong>only an attendant has access to that resource");
        }
        return $next($request);
    }
}
