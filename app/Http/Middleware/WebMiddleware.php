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

        if(app()->environment('production')){
        abort_if( (Route::currentRouteName() == 'login' || $request->is('/')) && $request->getHost() == api_url(),'403','dffd');

        if($request->segment(1) == 'api' || Route::currentRouteName() == 'stream' ){
            abort_if($request->segment(1) == 'api' && $request->getHost() != api_url(),'404','Not Found');
            abort_if(  Route::currentRouteName() == 'stream' && $request->getHost() != api_url() && !auth()->check(),'404','Not Found');
        }
    }

        return $next($request);
    }
}
