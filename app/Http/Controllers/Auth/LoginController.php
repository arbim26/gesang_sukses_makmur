<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;          
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;  
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function showLoginForm()
    {
        if (Auth::guard('pegawai')->check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Proses login pegawai.
     */
    public function login(Request $request)
    {
        // 1. Validasi Input Form
        $request->validate([
            'id_pegawai' => 'required|string',
            'password'   => 'required|string',
        ], [
            'id_pegawai.required' => 'ID Pegawai wajib diisi.',
            'password.required'   => 'Password wajib diisi.',
        ]);

        // 2. Cari data pegawai berdasarkan Id_Pegawai (Sesuai kolom kapital di DB)
        $pegawai = Pegawai::where('Id_Pegawai', $request->id_pegawai)->first();

        // 3. Verifikasi: Apakah pegawai ditemukan & password-nya cocok?
        if ($pegawai && Hash::check($request->password, $pegawai->password)) {
            
            // 4. Jika cocok, login pegawai secara manual ke dalam session guard
            $remember = $request->boolean('remember');
            Auth::guard('pegawai')->login($pegawai, $remember);
            
            // 5. Regenerasi session agar aman dari session fixation
            $request->session()->regenerate();
            
            return redirect()->route('dashboard');
        }

        // 6. Jika gagal, kembalikan ke halaman login dengan pesan error
        return back()
            ->withInput($request->only('id_pegawai'))
            ->withErrors([
                'id_pegawai' => 'ID Pegawai atau password yang Anda masukkan salah.',
            ]);
    }

    /**
     * Logout pegawai.
     */
    public function logout(Request $request)
    {
        Auth::guard('pegawai')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda berhasil keluar dari sistem.');
    }
}