<?php

namespace App\Http\Middleware;

use Closure;

class CheckMobileApiAuth
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
        if (!isset($request->auth) ) {
            return response()->json([
                'status' => false,
                'error' => 'Authorization failed, authentication key did not provide.'
            ]);
        }
        if($request->auth != 'mobileappauth') {
            return response()->json([
                'status' => false,
                'error' => 'Authorization failed, wrong authentication key.'
            ]);
        }
        return $next($request);
    }
}
