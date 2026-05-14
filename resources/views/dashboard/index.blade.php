@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<section class="section section-gray" style="min-height:calc(100vh - 70px - 300px);">
    <div class="section-container">
        <!-- Welcome Banner -->
        <div class="dashboard-welcome">
            <div>
                <h2>Selamat Datang, {{ auth()->user()->name }}!</h2>
                <p>Kelola laporan kenakalan remaja Anda di sini.</p>
            </div>
            <a href="{{ url('/lapor') }}" class="btn btn-white">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="5" x2="12" y2="19"/>
                    <line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Buat Laporan Baru
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-card-icon green">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                    </svg>
                </div>
                <div class="stat-card-value">{{ $totalReports }}</div>
                <div class="stat-card-label">Total Laporan</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-icon blue">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                </div>
                <div class="stat-card-value">{{ $baruReports }}</div>
                <div class="stat-card-label">Baru</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-icon yellow">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="23 4 23 10 17 10"/>
                        <path d="M20.49 15a9 9 0 11-2.12-9.36L23 10"/>
                    </svg>
                </div>
                <div class="stat-card-value">{{ $diprosesReports }}</div>
                <div class="stat-card-label">Diproses</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-icon green">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                </div>
                <div class="stat-card-value">{{ $selesaiReports }}</div>
                <div class="stat-card-label">Selesai</div>
            </div>
        </div>

        <!-- Quick Action -->
        <div style="text-align:center;margin-bottom:20px;">
            <a href="{{ route('dashboard.laporan.index') }}" class="btn btn-outline">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                </svg>
                Lihat Semua Laporan
            </a>
        </div>
    </div>
</section>

@endsection
