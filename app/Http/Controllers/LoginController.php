<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        dd($request);
        $request->validate([
            'id_pegawai' => 'required|string',
            'password'   => 'required|string',
        ], [
            'id_pegawai.required' => 'ID Pegawai wajib diisi.',
            'password.required'   => 'Password wajib diisi.',
        ]);

        $credentials = $request->only('id_pegawai', 'password');
        $remember    = $request->boolean('remember');

        if (Auth::guard('pegawai')->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

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
