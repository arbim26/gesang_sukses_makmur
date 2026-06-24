<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckJabatan
{
    /**
<<<<<<< HEAD
<<<<<<< HEAD
     * Cek apakah pegawai memiliki jabatan yang diizinkan.
=======
     * Handle an incoming request.
>>>>>>> 295042f63e0e6b961cd858a8aef381f99c0de7e1
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$jabatans
     */
<<<<<<< HEAD
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
=======
    public function handle(Request $request, Closure $next, ...$jabatans)
>>>>>>> 295042f63e0e6b961cd858a8aef381f99c0de7e1
    {
        // 1. Ambil data pegawai yang sedang login lewat guard pegawai
        $pegawai = Auth::guard('pegawai')->user();

<<<<<<< HEAD
<<<<<<< HEAD
        if (!$pegawai->hasJabatan(...$jabatan)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini. Jabatan Anda: ' . $pegawai->jabatan);
=======
=======
>>>>>>> 295042f63e0e6b961cd858a8aef381f99c0de7e1
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
<<<<<<< HEAD
>>>>>>> f51e716 (add JWT and Multi Role)
=======
>>>>>>> 295042f63e0e6b961cd858a8aef381f99c0de7e1
        }

        return $next($request);
    }
}