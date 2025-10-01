<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanonicalUrl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $uri = $request->getRequestUri();
        $uri = preg_replace('#^/(en|ar|ru)/(en|ar|ru)(/|$)#', '/$2$3', $uri);

        if ($uri !== '/' && str_ends_with($uri, '/')) {
            $uri = rtrim($uri, '/');
        }

        if ($uri !== $request->getRequestUri()) {
            return redirect()->to($uri, 301);
        }

        return $next($request);
    }
}
