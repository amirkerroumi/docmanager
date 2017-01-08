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
    /*
     * This Middleware class handles requests where the user is supposed to be authenticated (logged in to the api)
     */
    public function handle($request, Closure $next)
    {
        /*
         * Request handled normally if user is logged in and his session is valid, otherwise redirection to login page
         */
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
