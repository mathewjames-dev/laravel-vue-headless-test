<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ensure the request has the Authorization header and that it = eyJhbGciOiJIUzI1NiJ9.eyJJc3N1ZXIiOiJNYXRoZXdKYW1lcyIsImV4cCI6MTcxMTc5NzkxMSwiaWF0IjoxNzEwNjc0NzExfQ.HxDAOqRrM9R9lMYRnXoDMioC1iK1Jcd_NVcjPeEA3l0
        if (!$request->header('Authorization') || $request->header('Authorization') !== 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJJc3N1ZXIiOiJNYXRoZXdKYW1lcyIsImV4cCI6MTcxMTc5NzkxMSwiaWF0IjoxNzEwNjc0NzExfQ.HxDAOqRrM9R9lMYRnXoDMioC1iK1Jcd_NVcjPeEA3l0') {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }
        return $next($request);
    }
}
