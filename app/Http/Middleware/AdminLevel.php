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
        if(Auth::guest() || !Auth::user()->isAdmin()){
            return redirect()->back()->with('info', 'Only admin is authorized for that');
        }
        return $next($request);
    }
}
