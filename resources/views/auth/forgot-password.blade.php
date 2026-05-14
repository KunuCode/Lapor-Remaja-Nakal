@extends('layouts.app')

@section('title', 'Lupa Password')

@section('content')

<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-card-header">
            <div class="auth-card-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0110 0v4"/>
                </svg>
            </div>
            <h2>Lupa Password</h2>
            <p>Masukkan email Anda untuk mendapatkan link reset password</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-input {{ $errors->has('email') ? 'is-error' : '' }}" value="{{ old('email') }}" placeholder="email@contoh.com" autofocus>
                @error('email')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group" style="margin-bottom:0;">
                <button type="submit" class="btn btn-primary btn-block">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="22" y1="2" x2="11" y2="13"/>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                    </svg>
                    Kirim Link Reset
                </button>
            </div>
        </form>

        <div class="auth-footer">
            <p><a href="{{ route('login') }}">&#8592; Kembali ke halaman masuk</a></p>
        </div>
    </div>
</div>

@endsection
