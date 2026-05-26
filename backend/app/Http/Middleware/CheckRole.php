<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     * Usage: middleware('role:admin') or middleware('role:admin,dosen')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        if (!in_array($request->user()->role, $roles)) {
            return response()->json([
                'message' => 'Akses ditolak. Role tidak sesuai.',
                'your_role' => $request->user()->role,
                'required_roles' => $roles,
            ], 403);
        }

        return $next($request);
    }
}
