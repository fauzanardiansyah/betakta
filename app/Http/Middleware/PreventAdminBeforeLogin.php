<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class PreventAdminBeforeLogin
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
        if(Session::has('is_login_super_admin') === FALSE ) {
            return redirect()->route('admin.auth');
        }
        return $next($request);
    }
}
