<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class WebMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        abort_if( (Route::currentRouteName() == 'login' || $request->is('/')) && $request->getHost() == api_url(),'403');

        if($request->segment(1) == 'api' || Route::currentRouteName() == 'stream' ){
            abort_if( $request->getHost() != api_url(),'404','Not Found');
        }

        return $next($request);
    }
}
