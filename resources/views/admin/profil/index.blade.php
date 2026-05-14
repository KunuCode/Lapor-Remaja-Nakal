@extends('layouts.admin')

@section('admin-content')

<div class="admin-page-header">
    <h1>Kelola Profil</h1>
</div>

<!-- Tabs -->
<div class="profile-tabs">
    <button class="profile-tab active" onclick="switchTab('visiMisi', this)">Visi & Misi</button>
    <button class="profile-tab" onclick="switchTab('struktur', this)">Struktur Organisasi</button>
    <button class="profile-tab" onclick="switchTab('about', this)">Tentang Kecamatan</button>
</div>

<!-- Visi & Misi Panel -->
<div class="profile-panel active" id="panel-visiMisi">
    <div style="background:white;padding:24px;border-radius:var(--radius-md);box-shadow:var(--shadow-sm);">
        <form action="{{ route('admin.profil.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" value="visi_misi">

            <div class="form-group">
                <label class="form-label">Judul</label>
                <input type="text" name="title" class="form-input" value="{{ old('title', $visiMisi->title ?? 'Visi & Misi') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Konten</label>
                <textarea name="content" class="form-textarea" rows="8" required>{{ old('content', $visiMisi->content ?? '') }}</textarea>
            </div>
            @if(isset($visiMisi) && $visiMisi->image_path)
                <div class="form-group">
                    <label class="form-label">Gambar Saat Ini</label>
                    <img src="{{ asset($visiMisi->image_path) }}" alt="Gambar Visi Misi" style="max-width:300px;border-radius:var(--radius-sm);border:1px solid var(--border-color);">
                </div>
            @endif
            <div class="form-group">
                <label class="form-label">Upload Gambar Baru</label>
                <input type="file" name="image" class="form-input" accept="image/*" onchange="previewSingle(this, 'visiMisiPreview')">
                <div id="visiMisiPreview" class="mt-1"></div>
            </div>
            <button type="submit" class="btn btn-primary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                    <polyline points="17 21 17 13 7 13 7 21"/>
                    <polyline points="7 3 7 8 15 8"/>
                </svg>
                Simpan Visi & Misi
            </button>
        </form>
    </div>
</div>

<!-- Struktur Organisasi Panel -->
<div class="profile-panel" id="panel-struktur">
    <div style="background:white;padding:24px;border-radius:var(--radius-md);box-shadow:var(--shadow-sm);">
        <form action="{{ route('admin.profil.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" value="struktur">

            <div class="form-group">
                <label class="form-label">Judul</label>
                <input type="text" name="title" class="form-input" value="{{ old('title', $struktur->title ?? 'Struktur Organisasi') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Konten</label>
                <textarea name="content" class="form-textarea" rows="8" required>{{ old('content', $struktur->content ?? '') }}</textarea>
            </div>
            @if(isset($struktur) && $struktur->image_path)
                <div class="form-group">
                    <label class="form-label">Gambar Struktur Saat Ini</label>
                    <img src="{{ asset($struktur->image_path) }}" alt="Struktur Organisasi" style="max-width:400px;border-radius:var(--radius-sm);border:1px solid var(--border-color);">
                </div>
            @endif
            <div class="form-group">
                <label class="form-label">Upload Gambar Struktur Baru</label>
                <input type="file" name="image" class="form-input" accept="image/*" onchange="previewSingle(this, 'strukturPreview')">
                <div id="strukturPreview" class="mt-1"></div>
            </div>
            <button type="submit" class="btn btn-primary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                    <polyline points="17 21 17 13 7 13 7 21"/>
                    <polyline points="7 3 7 8 15 8"/>
                </svg>
                Simpan Struktur Organisasi
            </button>
        </form>
    </div>
</div>

<!-- Tentang Kecamatan Panel -->
<div class="profile-panel" id="panel-about">
    <div style="background:white;padding:24px;border-radius:var(--radius-md);box-shadow:var(--shadow-sm);">
        <form action="{{ route('admin.profil.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" value="about">

            <div class="form-group">
                <label class="form-label">Judul</label>
                <input type="text" name="title" class="form-input" value="{{ old('title', $about->title ?? 'Tentang Kecamatan Silaen') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Konten</label>
                <textarea name="content" class="form-textarea" rows="8" required>{{ old('content', $about->content ?? '') }}</textarea>
            </div>
            @if(isset($about) && $about->image_path)
                <div class="form-group">
                    <label class="form-label">Gambar Saat Ini</label>
                    <img src="{{ asset($about->image_path) }}" alt="Tentang Kecamatan" style="max-width:300px;border-radius:var(--radius-sm);border:1px solid var(--border-color);">
                </div>
            @endif
            <div class="form-group">
                <label class="form-label">Upload Gambar Baru</label>
                <input type="file" name="image" class="form-input" accept="image/*" onchange="previewSingle(this, 'aboutPreview')">
                <div id="aboutPreview" class="mt-1"></div>
            </div>
            <button type="submit" class="btn btn-primary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                    <polyline points="17 21 17 13 7 13 7 21"/>
                    <polyline points="7 3 7 8 15 8"/>
                </svg>
                Simpan Tentang Kecamatan
            </button>
        </form>
    </div>
</div>

<script>
    function switchTab(panel, btn) {
        document.querySelectorAll('.profile-panel').forEach(p => p.classList.remove('active'));
        document.querySelectorAll('.profile-tab').forEach(t => t.classList.remove('active'));
        document.getElementById('panel-' + panel).classList.add('active');
        btn.classList.add('active');
    }

    function previewSingle(input, previewId) {
        const container = document.getElementById(previewId);
        container.innerHTML = '';
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                container.innerHTML = `<img src="${e.target.result}" style="max-width:200px;max-height:150px;border-radius:var(--radius-sm);border:1px solid var(--border-color);" alt="Preview">`;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@endsection
