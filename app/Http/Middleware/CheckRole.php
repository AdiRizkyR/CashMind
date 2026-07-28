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
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Memastikan pengguna sudah login dan role pengguna sesuai dengan parameter
        if (!$request->user() || $request->user()->role !== $role) {
            // Jika role pengguna adalah admin namun mencoba akses area user atau sebaliknya
            if ($request->user() && $request->user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('user.dashboard');
        }

        return $next($request);
    }
}
