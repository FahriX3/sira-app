<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAccountVerified
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && !auth()->user()->is_verified) {
            auth()->logout();
            return redirect()->route('login')
                ->with('error', 'Akun Anda belum diverifikasi oleh Pengurus RT. Silakan tunggu verifikasi.');
        }

        return $next($request);
    }
}
