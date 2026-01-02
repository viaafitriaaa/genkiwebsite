<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard')->with('success', 'Berhasil login!');
        }

        return back()->withErrors([
            'login_error' => 'Username atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function showRegister()
    {
        return view('signup');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username|min-3',
            'password' => 'required|min-5|confirmed', // konfirmasi password 
        ]);

        // Create user
        \App\Models\User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password), // enkripsi
        ]);

        return redirect()->route('admin.login')->with('success', 'Akun berhasil dibuat!');
    }
}
