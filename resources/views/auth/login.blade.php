@extends('layouts.app')

@section('title', 'Masuk')

@section('content')

<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-card-header">
            <div class="auth-card-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/>
                    <polyline points="10 17 15 12 10 7"/>
                    <line x1="15" y1="12" x2="3" y2="12"/>
                </svg>
            </div>
            <h2>Masuk</h2>
            <p>Masuk ke akun Anda untuk melapor</p>
        </div>

        @if(session('error'))
            <div class="alert alert-error">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-input {{ $errors->has('email') ? 'is-error' : '' }}" value="{{ old('email') }}" placeholder="email@contoh.com" autofocus>
                @error('email')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-input {{ $errors->has('password') ? 'is-error' : '' }}" placeholder="Masukkan password">
                @error('password')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group" style="margin-bottom:0;">
                <button type="submit" class="btn btn-primary btn-block">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/>
                        <polyline points="10 17 15 12 10 7"/>
                        <line x1="15" y1="12" x2="3" y2="12"/>
                    </svg>
                    Masuk
                </button>
            </div>
        </form>

        <div class="auth-footer">
            <p>Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
            <p class="mt-1"><a href="{{ route('password.request') }}" style="font-size:0.85rem;">Lupa Password?</a></p>
        </div>
    </div>
</div>

@endsection
