<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Cek apakah user login DAN apakah role-nya sesuai
        if (! $request->user() || $request->user()->role !== $role) {
            abort(403, 'Akses Ditolak! Anda tidak memiliki izin ke halaman ini.');
        }

        return $next($request);
    }
}