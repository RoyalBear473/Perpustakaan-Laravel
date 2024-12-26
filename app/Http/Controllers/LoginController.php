<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Petugas;

class LoginController extends Controller
{
    /**
     * halaman login
     */
    public function index()
    {
        return view('login');
    }

    /**
     * proses login
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);
        $masuk = $request->only('username', 'password');
        if (Auth::attempt($masuk)) {
            return redirect()->intended('/content/peminjaman')->with('success', 'Login Berhasil');
        }
        return back()->withErrors([
            'login' => 'username atau password salah'
        ]);
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Logout berhasil.');
    }
}
