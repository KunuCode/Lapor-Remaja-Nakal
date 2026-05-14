@extends('layouts.admin')

@section('admin-content')

<a href="{{ route('admin.laporan.index') }}" class="back-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <line x1="19" y1="12" x2="5" y2="12"/>
        <polyline points="12 19 5 12 12 5"/>
    </svg>
    Kembali ke Daftar Laporan
</a>

<div class="report-detail" style="max-width:100%;">
    <!-- Header -->
    <div class="report-detail-header">
        <h1>{{ $report->title }}</h1>
        <span class="badge badge-{{ $report->status }}">{{ ucfirst($report->status) }}</span>
    </div>

    <div style="display:grid;grid-template-columns:1fr 380px;gap:24px;align-items:start;">
        <!-- Left Column: Report Info -->
        <div>
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
        </div>

        <!-- Right Column: Status Update -->
        <div>
            <div style="background:white;padding:24px;border-radius:var(--radius-md);box-shadow:var(--shadow-sm);border:1px solid var(--border-light);position:sticky;top:100px;">
                <h3 style="font-size:1rem;font-weight:700;margin-bottom:16px;color:var(--text-dark);">Update Status Laporan</h3>

                <form action="{{ route('admin.laporan.updateStatus', $report->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="baru" {{ $report->status === 'baru' ? 'selected' : '' }}>Baru</option>
                            <option value="diproses" {{ $report->status === 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ $report->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="ditolak" {{ $report->status === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Catatan Admin</label>
                        <textarea name="admin_note" class="form-textarea" rows="4" placeholder="Tulis catatan untuk pelapor...">{{ old('admin_note', $report->admin_note) }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                            <polyline points="17 21 17 13 7 13 7 21"/>
                            <polyline points="7 3 7 8 15 8"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
