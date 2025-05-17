<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function index()
    {
        // Mengembalikan tampilan login
        return view('login.index');
    }

    /**
     * Mengautentikasi pengguna berdasarkan email dan password.
     */
    public function login(Request $request)
    {
        // Validasi input email dan password dari pengguna
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Ambil nilai remember (true/false)
        $remember = $request->filled('remember');

        // Cek apakah kredensial yang dimasukkan valid dan cocok dengan data yang ada
        if (Auth::attempt($credentials, $remember)) {
            // Regenerasi sesi untuk mencegah session fixation attack
            $request->session()->regenerate();

            return redirect()->route('dashboard')->with('success', 'Login successful!');
        }

        return back()->with('loginError', 'Login failed!');
    }
    /**
     * Menglogout pengguna dan menghapus sesi.
     */
    public function logout()
    {
        // Logout pengguna
        Auth::logout();

        // Hapus sesi pengguna
        request()->session()->invalidate();

        // Regenerasi token sesi untuk mencegah serangan CSRF
        request()->session()->regenerateToken();

        // Setelah logout, arahkan pengguna ke halaman utama
        return redirect('/');
    }
}
