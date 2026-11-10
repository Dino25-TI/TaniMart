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
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan masuk terlebih dahulu untuk mengakses halaman admin.');
        }

        if (!auth()->user()->isAdmin()) {
            return redirect('/')->with('error', 'Akses ditolak! Halaman ini hanya diperuntukkan untuk Administrator.');
        }

        return $next($request);
    }
}

