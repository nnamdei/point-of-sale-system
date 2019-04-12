<?php

namespace App\Http\Middleware;

use Auth;
use App\Shop;
use Closure;

class CheckShop
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
        if(Auth::check() && Auth::user()->hasShop()){
        }
        else{
            return redirect()->route('no.shop')->with('info','You are currently not checked in any shop yet');
        }

        return $next($request);
    }
}
