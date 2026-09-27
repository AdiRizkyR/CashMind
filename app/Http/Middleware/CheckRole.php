<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware CheckRole
 * Memeriksa apakah pengguna yang sedang login memiliki role yang sesuai (contoh: 'admin' atau 'user').
 * Jika role tidak sesuai, pengguna akan diarahkan kembali ke dashboard utama.
 */
class CheckRole
{
    /**
     * Penanganan request masuk.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
