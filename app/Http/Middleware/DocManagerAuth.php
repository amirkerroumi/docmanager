<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;

class DocManagerAuth
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
        if($request->session()->has('access_token') && $request->session()->has('access_token_expiration_time'))
        {
            $time = Carbon::now();
            if(!empty($request->session()->get('access_token')) && $time < $request->session()->get('access_token_expiration_time'))
            {
                return $next($request);
            }
        }
        $request->session()->flush();
        return redirect('/login');
    }
}
