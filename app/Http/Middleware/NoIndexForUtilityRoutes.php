<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NoIndexForUtilityRoutes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (
            $request->is('*/login') ||
            $request->is('*/login/*') ||
            $request->is('*/language/*/switch') ||
            $request->is('*/country/*/switch') ||
            $request->is('*/city/*/switch') ||
            $request->is('*/currency/*/switch')
        ) {
            $response->headers->set('X-Robots-Tag', 'noindex, nofollow');
        }
        
        return $next($request);
    }
}
