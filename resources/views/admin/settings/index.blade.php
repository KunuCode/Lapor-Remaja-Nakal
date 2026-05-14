@extends('layouts.admin')

@section('admin-content')

<div class="admin-page-header">
    <h1>Pengaturan Website</h1>
</div>

<!-- Update Site Name -->
<div style="background:white;padding:24px;border-radius:var(--radius-md);box-shadow:var(--shadow-sm);margin-bottom:24px;">
    <h3 style="font-size:1.1rem;font-weight:700;color:var(--text-dark);margin-bottom:16px;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" style="vertical-align:middle;margin-right:8px;">
            <circle cx="12" cy="12" r="3"/>
            <path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z"/>
        </svg>
        Nama & Deskripsi Website
    </h3>
    <form action="{{ route('admin.settings.updateSiteName') }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="form-label">Nama Website</label>
            <input type="text" name="site_name" class="form-input" value="{{ old('site_name', $settings['site_name'] ?? 'Lapor Remaja Nakal') }}" required>
        </div>
        <div class="form-group">
            <label class="form-label">Deskripsi Website</label>
            <textarea name="site_description" class="form-textarea" rows="3">{{ old('site_description', $settings['site_description'] ?? '') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
    </form>
</div>

<!-- Upload Logo -->
<div style="background:white;padding:24px;border-radius:var(--radius-md);box-shadow:var(--shadow-sm);margin-bottom:24px;">
    <h3 style="font-size:1.1rem;font-weight:700;color:var(--text-dark);margin-bottom:16px;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" style="vertical-align:middle;margin-right:8px;">
            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
            <circle cx="8.5" cy="8.5" r="1.5"/>
            <polyline points="21 15 16 10 5 21"/>
        </svg>
        Logo Website
    </h3>
    <p class="form-help" style="margin-bottom:16px;">Upload logo yang akan ditampilkan di navbar website. Format: PNG, JPG, SVG, ICO. Ukuran maksimal 2MB. Disarankan ukuran 40x40 pixel atau lebih dengan background transparan.</p>

    @if(isset($settings['site_logo']) && $settings['site_logo'])
        <div style="margin-bottom:16px;">
            <label class="form-label">Logo Saat Ini:</label>
            <div style="background:var(--bg-gray);padding:16px;border-radius:var(--radius-sm);display:inline-block;">
                <img src="{{ asset($settings['site_logo']) }}" alt="Logo" style="max-height:60px;max-width:200px;">
            </div>
        </div>
    @endif

    <form action="{{ route('admin.settings.updateLogo') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label class="form-label">Upload Logo Baru</label>
            <input type="file" name="logo" class="form-input" accept="image/*" onchange="previewSingle(this, 'logoPreview')">
            <div id="logoPreview" class="mt-1"></div>
        </div>
        <button type="submit" class="btn btn-primary">Upload Logo</button>
    </form>
</div>

<!-- Upload Favicon -->
<div style="background:white;padding:24px;border-radius:var(--radius-md);box-shadow:var(--shadow-sm);margin-bottom:24px;">
    <h3 style="font-size:1.1rem;font-weight:700;color:var(--text-dark);margin-bottom:16px;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" style="vertical-align:middle;margin-right:8px;">
            <path d="M12 2L2 7l10 5 10-5-10-5z"/>
            <path d="M2 17l10 5 10-5"/>
            <path d="M2 12l10 5 10-5"/>
        </svg>
        Favicon (Ikon Tab Browser)
    </h3>
    <p class="form-help" style="margin-bottom:16px;">Upload favicon yang akan ditampilkan di tab browser. Format: PNG atau ICO. Ukuran disarankan 32x32 pixel.</p>

    @if(isset($settings['site_favicon']) && $settings['site_favicon'])
        <div style="margin-bottom:16px;">
            <label class="form-label">Favicon Saat Ini:</label>
            <div style="background:var(--bg-gray);padding:16px;border-radius:var(--radius-sm);display:inline-block;">
                <img src="{{ asset($settings['site_favicon']) }}" alt="Favicon" style="max-height:32px;max-width:32px;">
            </div>
        </div>
    @endif

    <form action="{{ route('admin.settings.updateFavicon') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label class="form-label">Upload Favicon Baru</label>
            <input type="file" name="favicon" class="form-input" accept="image/png,image/x-icon,image/svg+xml" onchange="previewSingle(this, 'faviconPreview')">
            <div id="faviconPreview" class="mt-1"></div>
        </div>
        <button type="submit" class="btn btn-primary">Upload Favicon</button>
    </form>
</div>

<script>
    function previewSingle(input, previewId) {
        const container = document.getElementById(previewId);
        container.innerHTML = '';
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                container.innerHTML = `<img src="${e.target.result}" style="max-width:200px;max-height:100px;border-radius:var(--radius-sm);border:1px solid var(--border-color);" alt="Preview">`;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@endsection