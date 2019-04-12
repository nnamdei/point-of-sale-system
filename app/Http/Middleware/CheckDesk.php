<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckDesk
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
        if(Auth::check() && Auth::user()->deskClosed()){
            return redirect()->route('desk.closed')->with('info', 'Your register is closed');
        }
        return $next($request);
    }
}
