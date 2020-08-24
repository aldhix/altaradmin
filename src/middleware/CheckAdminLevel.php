<?php

namespace Aldhix\Altaradmin\Middleware;

use Closure;
use Auth;

class CheckAdminLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $level = null)
    {
        if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->level == $level) {
            return $next($request);    
        }

        return abort(404);
        
    }
}
