<?php

namespace App\Http\Middleware;

use DB;
use Auth;
use App\Software;
use Closure;

class SystemStatus
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
        $software = Software::first();
        if(!$software->isActive()){
            // Allow super admin to continue...
            if(Auth::check() && Auth::user()->isSuperAdmin()){
                return $next($request);
            }
            //...but bounce any other user back
            return redirect()->route('system.status');
        }
        return $next($request);

    }
}
