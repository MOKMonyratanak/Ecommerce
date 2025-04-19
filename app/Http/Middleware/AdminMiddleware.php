<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the authenticated user has the 'admin' role
        dd('Working');
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        // Return a 403 Forbidden response if the user is not an admin
        // return response()->json(['message' => 'Forbidden: Admins only'], 403);
    }
}
