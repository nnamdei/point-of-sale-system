<?php

namespace App\Http\Middleware;

use DB;
use App\Software;
use Closure;

class PremiumOnly
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
        if(!$software->isPremium()){
            return redirect()->back()->with('info', 'Available only in premium');
        }
        return $next($request);
    }
}
