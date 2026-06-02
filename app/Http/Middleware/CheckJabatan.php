<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckJabatan
{
    /**
     * Cek apakah pegawai memiliki jabatan yang diizinkan.
     *
     * Contoh pemakaian di route:
     *   ->middleware('jabatan:Manager,Supervisor')
     *   ->middleware('jabatan:Direktur')
     */
    public function handle(Request $request, Closure $next, string ...$jabatan): Response
    {
        if (!Auth::guard('pegawai')->check()) {
            return redirect()->route('login');
        }

        $pegawai = Auth::guard('pegawai')->user();

        if (!$pegawai->hasJabatan(...$jabatan)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini. Jabatan Anda: ' . $pegawai->jabatan);
        }

        return $next($request);
    }
}
