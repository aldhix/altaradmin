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
    public function handle($request, Closure $next, ... $roles)
    {
        $check = Auth::guard('admin')->check();
        $level = Auth::guard('admin')->user()->level;

        if($check && in_array($level, $roles)) {
            return $next($request);    
        }


        return abort(404);
        
    }
}
