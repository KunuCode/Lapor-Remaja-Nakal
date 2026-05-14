<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MasyarakatMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Admin boleh mengakses semua halaman
        if (auth()->user()->isAdmin()) {
            return redirect('/admin');
        }

        return $next($request);
    }
}
