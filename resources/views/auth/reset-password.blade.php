@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')

<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-card-header">
            <div class="auth-card-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0110 0v4"/>
                    <circle cx="12" cy="16" r="1"/>
                </svg>
            </div>
            <h2>Reset Password</h2>
            <p>Masukkan password baru untuk akun Anda</p>
        </div>

        @if(session('error'))
            <div class="alert alert-error">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <label class="form-label">Password Baru</label>
                <input type="password" name="password" class="form-input {{ $errors->has('password') ? 'is-error' : '' }}" placeholder="Minimal 6 karakter" autofocus>
                @error('password')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-input" placeholder="Ulangi password baru">
            </div>

            <div class="form-group" style="margin-bottom:0;">
                <button type="submit" class="btn btn-primary btn-block">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/>
                        <polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Simpan Password Baru
                </button>
            </div>
        </form>

        <div class="auth-footer">
            <p><a href="{{ route('login') }}">&#8592; Kembali ke halaman masuk</a></p>
        </div>
    </div>
</div>

@endsection
