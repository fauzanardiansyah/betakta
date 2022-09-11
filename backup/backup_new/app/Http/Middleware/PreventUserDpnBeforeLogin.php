<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class PreventUserDpnBeforeLogin
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
        if(Session::has('is_login_dewan_pusat') === FALSE ) {
            return redirect('/dpn/auth/signin');
        }
        return $next($request);
    }
}
