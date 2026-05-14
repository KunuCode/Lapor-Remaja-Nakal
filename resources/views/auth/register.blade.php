@extends('layouts.app')

@section('title', 'Daftar Akun')

@section('content')

<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-card-header">
            <div class="auth-card-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                    <circle cx="8.5" cy="7" r="4"/>
                    <line x1="20" y1="8" x2="20" y2="14"/>
                    <line x1="23" y1="11" x2="17" y2="11"/>
                </svg>
            </div>
            <h2>Daftar Akun</h2>
            <p>Buat akun baru untuk mulai melapor</p>
        </div>

        @if(session('error'))
            <div class="alert alert-error">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-input {{ $errors->has('name') ? 'is-error' : '' }}" value="{{ old('name') }}" placeholder="Masukkan nama lengkap">
                @error('name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-input {{ $errors->has('email') ? 'is-error' : '' }}" value="{{ old('email') }}" placeholder="email@contoh.com">
                @error('email')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">No HP</label>
                <input type="text" name="phone" class="form-input {{ $errors->has('phone') ? 'is-error' : '' }}" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx">
                @error('phone')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-input {{ $errors->has('password') ? 'is-error' : '' }}" placeholder="Minimal 6 karakter">
                @error('password')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-input" placeholder="Ulangi password">
            </div>

            <div class="form-group" style="margin-bottom:0;">
                <button type="submit" class="btn btn-primary btn-block">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                        <circle cx="8.5" cy="7" r="4"/>
                        <line x1="20" y1="8" x2="20" y2="14"/>
                        <line x1="23" y1="11" x2="17" y2="11"/>
                    </svg>
                    Daftar
                </button>
            </div>
        </form>

        <div class="auth-footer">
            <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
        </div>
    </div>
</div>

@endsection
