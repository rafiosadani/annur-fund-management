<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class PreventGetForPutRoutes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $restrictedMethods = ['PUT', 'PATCH', 'DELETE'];

        if ($request->method() === 'GET' && $request->route() && in_array($request->route()->methods()[0], $restrictedMethods)) {
            abort(404);
        }

        return $next($request);
    }
}
