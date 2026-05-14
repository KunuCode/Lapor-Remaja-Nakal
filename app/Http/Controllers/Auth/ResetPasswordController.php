<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request, $token)
    {
        try {
            $user = User::where('reset_token', $token)
                ->where('reset_token_exp', '>', now())
                ->first();

            if (!$user) {
                return redirect('/forgot-password')
                    ->with('error', 'Token reset password tidak valid atau sudah kadaluarsa. Silakan minta link baru.');
            }

            return view('auth.reset-password', compact('token'));
        } catch (\Exception $e) {
            return redirect('/forgot-password')
                ->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'token.required' => 'Token reset password wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        try {
            $user = User::where('reset_token', $request->token)
                ->where('reset_token_exp', '>', now())
                ->first();

            if (!$user) {
                return redirect('/forgot-password')
                    ->with('error', 'Token reset password tidak valid atau sudah kadaluarsa. Silakan minta link baru.');
            }

            $user->update([
                'password' => Hash::make($request->password),
                'reset_token' => null,
                'reset_token_exp' => null,
            ]);

            return redirect('/login')->with('success', 'Password berhasil diubah! Silakan login dengan password baru Anda.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengubah password. Silakan coba lagi.');
        }
    }
}
