@extends('layouts.admin')

@section('admin-content')

<div class="admin-page-header">
    <h1>Kelola Laporan</h1>
</div>

<!-- Filter Bar -->
<form method="GET" action="{{ route('admin.laporan.index') }}" class="filter-bar">
    <select name="status" class="form-select" onchange="this.form.submit()">
        <option value="">Semua Status</option>
        <option value="baru" {{ request('status') == 'baru' ? 'selected' : '' }}>Baru</option>
        <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
    </select>
    <input type="text" name="search" class="form-input" placeholder="Cari nama/judul laporan..." value="{{ request('search') }}">
    <button type="submit" class="btn btn-primary btn-sm">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/>
            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        Cari
    </button>
    @if(request('status') || request('search'))
        <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline btn-sm">Reset</a>
    @endif
</form>

@if($reports->count() > 0)
    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Pelapor</th>
                    <th>Kategori</th>
                    <th>Desa</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reports as $report)
                    <tr>
                        <td><strong>{{ Str::limit($report->title, 40) }}</strong></td>
                        <td>{{ $report->name }}</td>
                        <td>{{ $report->category }}</td>
                        <td>{{ $report->village }}</td>
                        <td>
                            <span class="badge badge-{{ $report->status }}">{{ ucfirst($report->status) }}</span>
                        </td>
                        <td>{{ $report->created_at->format('d/m/Y') }}</td>
                        <td class="actions">
                            <a href="{{ route('admin.laporan.show', $report->id) }}" class="btn btn-outline btn-sm">Detail</a>
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
        <p style="color:var(--text-light);">Belum ada laporan yang masuk.</p>
    </div>
@endif

@endsection