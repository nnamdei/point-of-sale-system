<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class AdminLevel
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
        if(Auth::check() && Auth::user()->isAdmin()){
            return $next($request);
        }
        else{
            return redirect()->back()->with('info', 'Only the admin is authorized for that');
        }
    }
}
