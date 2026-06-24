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

<<<<<<< HEAD
<<<<<<< HEAD

        $credentials = [
            'Id_Pegawai' => $request->id_pegawai, // Sesuai kolom DB (Kapital)
            'password'   => $request->password,   // Sesuai kolom DB (Kecil)
        ];
        $remember    = $request->boolean('remember');

        // dd(Auth::guard('pegawai')->attempt($credentials, $remember));

        // $user = Pegawai::where('Id_Pegawai', $request->id_pegawai)->first();
        // dd([
        //     'user_found'        => $user ? 'YES' : 'NO',
        //     'input_password'    => $request->password,
        //     'hashed_password'   => $user?->password,
        //     'password_check'    => $user ? Hash::check($request->password, $user->password) : 'N/A',
        //     'credentials'       => $credentials,
        //     'guard_provider'    => config('auth.guards.web'),
        //     'pegawai_provider'  => config('auth.providers.pegawais'),
        // ]);
        if (Auth::guard('pegawai')->attempt($credentials, $remember)){
=======
=======
>>>>>>> 295042f63e0e6b961cd858a8aef381f99c0de7e1
        // 3. Verifikasi: Apakah pegawai ditemukan & password-nya cocok?
        if ($pegawai && Hash::check($request->password, $pegawai->password)) {
            
            // 4. Jika cocok, login pegawai secara manual ke dalam session guard
            $remember = $request->boolean('remember');
            Auth::guard('pegawai')->login($pegawai, $remember);
            
            // 5. Regenerasi session agar aman dari session fixation
<<<<<<< HEAD
>>>>>>> f51e716 (add JWT and Multi Role)
=======
>>>>>>> 295042f63e0e6b961cd858a8aef381f99c0de7e1
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