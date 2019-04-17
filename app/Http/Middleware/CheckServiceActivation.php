<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class CheckServiceActivation
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
        if(Auth::user()->hasShop() && Auth::user()->shop->setting->serviceActivated()){
            return $next($request);
        }else{
            return redirect()->back()->with('info','Service is not enabled for '.Auth::user()->shop->name.'. Go to the shop settings and enable service to proceed');
        }

    }
}
