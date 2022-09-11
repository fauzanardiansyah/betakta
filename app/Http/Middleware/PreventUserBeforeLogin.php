<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class PreventUserBeforeLogin
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
        if(Session::has('is_login_agt') === FALSE ) {
            return redirect('/');
        }
        return $next($request);
    }
}
