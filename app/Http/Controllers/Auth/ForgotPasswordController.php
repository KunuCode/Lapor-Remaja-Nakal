<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Email tidak terdaftar dalam sistem kami.',
        ]);

        try {
            $user = User::where('email', $request->email)->first();

            $token = Str::random(60);

            $user->update([
                'reset_token' => $token,
                'reset_token_exp' => now()->addHours(1),
            ]);

            // Simulasi pengiriman email - token ditampilkan di flash message
            // Di production, kirim email yang berisi link reset password
            $resetUrl = url('/reset-password/' . $token);

            return redirect()->back()->with('success', 'Link reset password telah dikirim ke email Anda. ' .
                'Untuk keperluan demo, link reset: ' . $resetUrl);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengirim link reset password. Silakan coba lagi.')
                ->withInput($request->only('email'));
        }
    }
}
