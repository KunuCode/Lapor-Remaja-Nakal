@extends('layouts.admin')

@section('admin-content')

<div class="admin-page-header">
    <h1>Admin Dashboard</h1>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-icon purple">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 00-3-3.87"/>
                <path d="M16 3.13a4 4 0 010 7.75"/>
            </svg>
        </div>
        <div class="stat-card-value">{{ $totalUsers }}</div>
        <div class="stat-card-label">Total Pengguna</div>
    </div>
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
        <div class="stat-card-label">Laporan Baru</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon teal">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M2 3h6a4 4 0 014 4v14a3 3 0 00-3-3H2z"/>
                <path d="M22 3h-6a4 4 0 00-4 4v14a3 3 0 013-3h7z"/>
            </svg>
        </div>
        <div class="stat-card-value">{{ $totalNews }}</div>
        <div class="stat-card-label">Total Berita</div>
    </div>
</div>

<!-- Status Breakdown -->
<h3 style="font-size:1.15rem;font-weight:700;margin-bottom:16px;color:var(--text-dark);">Status Laporan</h3>
<div class="status-breakdown">
    <div class="status-card baru">
        <div class="status-card-value">{{ $baruReports }}</div>
        <div class="status-card-label">Baru</div>
    </div>
    <div class="status-card diproses">
        <div class="status-card-value">{{ $diprosesReports }}</div>
        <div class="status-card-label">Diproses</div>
    </div>
    <div class="status-card selesai">
        <div class="status-card-value">{{ $selesaiReports }}</div>
        <div class="status-card-label">Selesai</div>
    </div>
    <div class="status-card ditolak">
        <div class="status-card-value">{{ $ditolakReports }}</div>
        <div class="status-card-label">Ditolak</div>
    </div>
</div>

<!-- Quick Actions -->
<h3 style="font-size:1.15rem;font-weight:700;margin-bottom:16px;color:var(--text-dark);">Aksi Cepat</h3>
<div style="display:flex;gap:12px;flex-wrap:wrap;">
    <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
            <polyline points="14 2 14 8 20 8"/>
        </svg>
        Kelola Laporan
    </a>
    <a href="{{ route('admin.berita.index') }}" class="btn btn-outline">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M2 3h6a4 4 0 014 4v14a3 3 0 00-3-3H2z"/>
            <path d="M22 3h-6a4 4 0 00-4 4v14a3 3 0 013-3h7z"/>
        </svg>
        Kelola Berita
    </a>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 00-3-3.87"/>
            <path d="M16 3.13a4 4 0 010 7.75"/>
        </svg>
        Kelola Pengguna
    </a>
</div>

@endsection
