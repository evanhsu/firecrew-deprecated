<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;

class CapitalizeTailnumber
{
    /**
     * Handle an incoming request.
     * This Middleware checks for a 'tailnumber' parameter and converts it to all uppercase if it exists.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Route::current()->hasParameter('tailnumber')) {
            Route::current()->setParameter('tailnumber', strtoupper(Route::current()->getParameter('tailnumber')));
        }

        return $next($request);
    }
}
