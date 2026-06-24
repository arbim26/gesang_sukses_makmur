<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckJabatan
{
    /**
<<<<<<< HEAD
     * Cek apakah pegawai memiliki jabatan yang diizinkan.
     *
     * Contoh pemakaian di route:
     *   ->middleware('jabatan:Manager,Supervisor')
     *   ->middleware('jabatan:Direktur')
     */
    public function handle(Request $request, Closure $next, string ...$jabatan): Response
=======
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$jabatans
     */
    public function handle(Request $request, Closure $next, ...$jabatans)
>>>>>>> f51e716 (add JWT and Multi Role)
    {
        // 1. Ambil data pegawai yang sedang login lewat guard pegawai
        $pegawai = Auth::guard('pegawai')->user();

<<<<<<< HEAD
        if (!$pegawai->hasJabatan(...$jabatan)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini. Jabatan Anda: ' . $pegawai->jabatan);
=======
        if (!$pegawai) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated. Token tidak valid atau kedaluwarsa.'
            ], 401);
        }

        // 2. Cocokkan Jabatan pegawai dengan daftar jabatan yang diizinkan di route
        if (!in_array($pegawai->Jabatan, $jabatans)) {
            return response()->json([
                'success' => false,
                'message' => 'Forbidden: Jabatan Anda (' . $pegawai->Jabatan . ') tidak memiliki akses ke fitur ini.'
            ], 403);
>>>>>>> f51e716 (add JWT and Multi Role)
        }

        return $next($request);
    }
}
