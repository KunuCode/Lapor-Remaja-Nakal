@extends('layouts.app')

@section('title', 'Riwayat Laporan')

@section('content')

<section class="section section-gray" style="min-height:calc(100vh - 70px - 300px);">
    <div class="section-container">
        <div class="admin-page-header">
            <h1>Riwayat Laporan</h1>
            <a href="{{ url('/lapor') }}" class="btn btn-primary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="5" x2="12" y2="19"/>
                    <line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Buat Laporan Baru
            </a>
        </div>

        @if($reports->count() > 0)
            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $report)
                            <tr>
                                <td>
                                    <strong>{{ $report->title }}</strong>
                                </td>
                                <td>{{ $report->category }}</td>
                                <td>
                                    <span class="badge badge-{{ $report->status }}">{{ ucfirst($report->status) }}</span>
                                </td>
                                <td>{{ $report->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('dashboard.laporan.show', $report->id) }}" class="btn btn-outline btn-sm">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($reports->hasPages())
                <div class="pagination">
                    {{ $reports->withQueryString()->links() }}
                </div>
            @endif
        @else
            <div style="text-align:center;padding:60px 20px;background:white;border-radius:var(--radius-md);box-shadow:var(--shadow-sm);">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1.5" style="margin:0 auto 16px;display:block;">
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                </svg>
                <h3 style="color:var(--text-medium);margin-bottom:8px;">Belum Ada Laporan</h3>
                <p style="color:var(--text-light);margin-bottom:20px;">Anda belum membuat laporan apapun.</p>
                <a href="{{ url('/lapor') }}" class="btn btn-primary">Buat Laporan Pertama</a>
            </div>
        @endif
    </div>
</section>

@endsection
