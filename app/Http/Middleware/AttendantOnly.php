<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class AttendantOnly
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
        if(Auth::check() && Auth::user()->isAttendant()){
            return $next($request);
        }
        return redirect()->back()->with('info', 'Only an attendant is priviledged for that');
    }
}
