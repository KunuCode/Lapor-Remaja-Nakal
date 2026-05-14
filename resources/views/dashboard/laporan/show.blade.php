@extends('layouts.app')

@section('title', 'Detail Laporan')

@section('content')

<section class="section section-gray" style="min-height:calc(100vh - 70px - 300px);">
    <div class="section-container">
        <a href="{{ route('dashboard.laporan.index') }}" class="back-link">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="19" y1="12" x2="5" y2="12"/>
                <polyline points="12 19 5 12 12 5"/>
            </svg>
            Kembali ke Riwayat Laporan
        </a>

        <div class="report-detail">
            <!-- Header -->
            <div class="report-detail-header">
                <h1>{{ $report->title }}</h1>
                <span class="badge badge-{{ $report->status }}">{{ ucfirst($report->status) }}</span>
            </div>

            <!-- Reporter Info -->
            <div class="report-info-grid">
                <div class="report-info-item">
                    <label>Nama Pelapor</label>
                    <p>{{ $report->name }}</p>
                </div>
                <div class="report-info-item">
                    <label>Email</label>
                    <p>{{ $report->email }}</p>
                </div>
                <div class="report-info-item">
                    <label>No HP</label>
                    <p>{{ $report->phone }}</p>
                </div>
                <div class="report-info-item">
                    <label>Kategori</label>
                    <p>{{ $report->category }}</p>
                </div>
                <div class="report-info-item">
                    <label>Desa/Kelurahan</label>
                    <p>{{ $report->village }}</p>
                </div>
                <div class="report-info-item">
                    <label>Tanggal Laporan</label>
                    <p>{{ $report->created_at->format('d F Y, H:i') }}</p>
                </div>
            </div>

            <!-- Address -->
            <div class="report-info-item mb-3">
                <label>Alamat Lengkap</label>
                <p>{{ $report->address }}</p>
            </div>

            <!-- Description -->
            <div class="report-description">
                <h3>Deskripsi Kejadian</h3>
                <p>{!! nl2br(e($report->description)) !!}</p>
            </div>

            <!-- Photos -->
            @if($report->images->count() > 0)
                <h3 style="font-size:1rem;font-weight:700;margin-bottom:12px;">Foto Kejadian</h3>
                <div class="report-photos">
                    @foreach($report->images as $image)
                        <div class="report-photo">
                            <img src="{{ asset($image->image_path) }}" alt="Foto laporan">
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Status Timeline -->
            <div class="status-timeline">
                <h3>Status Laporan</h3>
                <div class="timeline-items">
                    <div class="timeline-item completed">
                        <p class="timeline-item-label">Laporan Dibuat</p>
                        <p class="timeline-item-time">{{ $report->created_at->format('d F Y, H:i') }}</p>
                    </div>
                    <div class="timeline-item {{ in_array($report->status, ['diproses', 'selesai']) ? 'completed' : ($report->status === 'baru' ? 'current' : '') }}">
                        <p class="timeline-item-label">Diverifikasi Admin</p>
                    </div>
                    <div class="timeline-item {{ $report->status === 'diproses' ? 'current' : ($report->status === 'selesai' ? 'completed' : '') }}">
                        <p class="timeline-item-label">Sedang Ditindaklanjuti</p>
                    </div>
                    <div class="timeline-item {{ $report->status === 'selesai' ? 'completed' : '' }}">
                        <p class="timeline-item-label">Selesai</p>
                    </div>
                </div>
            </div>

            <!-- Admin Note -->
            @if($report->admin_note)
                <div class="admin-note">
                    <h4>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:middle;margin-right:4px;">
                            <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>
                        </svg>
                        Catatan Admin
                    </h4>
                    <p>{!! nl2br(e($report->admin_note)) !!}</p>
                </div>
            @endif
        </div>
    </div>
</section>

@endsection
