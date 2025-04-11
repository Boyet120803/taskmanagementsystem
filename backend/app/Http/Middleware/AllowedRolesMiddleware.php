<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AllowedRolesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$roles)
    {
        $user = $request->user();
    
        if ($user->role == 0) {
            return $next($request);
        }
        if ($user->role == 1) {
            return $next($request);
        }
        if ($user->role == 2) {
            return $next($request);
        }
        return response()->json(['message' => 'Access denied'], 403);
    }
    

}
