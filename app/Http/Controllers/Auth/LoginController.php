<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        try {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials, $request->filled('remember'))) {
                $request->session()->regenerate();

                if (auth()->user()->isAdmin()) {
                    return redirect('/admin')->with('success', 'Selamat datang, Administrator!');
                }

                return redirect('/dashboard')->with('success', 'Berhasil login! Selamat datang, ' . auth()->user()->name);
            }

            return redirect()->back()
                ->with('error', 'Email atau password salah.')
                ->withInput($request->only('email'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat login. Silakan coba lagi.')
                ->withInput($request->only('email'));
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda berhasil logout.');
    }
}
