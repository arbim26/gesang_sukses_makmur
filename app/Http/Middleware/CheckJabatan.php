<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckJabatan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$jabatans
     */
    public function handle(Request $request, Closure $next, ...$jabatans)
    {
        // 1. Ambil data pegawai yang sedang login lewat guard pegawai
        $pegawai = Auth::guard('pegawai')->user();

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
        }

        return $next($request);
    }
}