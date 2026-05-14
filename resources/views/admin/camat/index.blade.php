@extends('layouts.admin')

@section('admin-content')

<div class="admin-page-header">
    <h1>Kelola Data Camat</h1>
    <button class="btn btn-primary" onclick="openModal('addCamatModal')">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Tambah Camat
    </button>
</div>

@if($camats->count() > 0)
    <div class="camat-grid">
        @foreach($camats as $camat)
            <div class="camat-card">
                <img src="{{ asset($camat->image_path) }}" alt="{{ $camat->name }}">
                <h4>{{ $camat->name }}</h4>
                <p class="position">{{ $camat->position }}</p>
                @if($camat->bio)
                    <p class="bio">{{ Str::limit($camat->bio, 150) }}</p>
                @endif
                <div class="d-flex gap-1 justify-center" style="justify-content:center;">
                    <button class="btn btn-outline btn-sm" onclick="openEditCamat({{ $camat->id }}, '{{ addslashes($camat->name) }}', '{{ addslashes($camat->position) }}', '{{ addslashes($camat->bio ?? '') }}', '{{ asset($camat->image_path) }}')">Edit</button>
                    <form action="{{ route('admin.camat.destroy', $camat->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data camat ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-destructive btn-sm">Hapus</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div style="text-align:center;padding:60px 20px;background:white;border-radius:var(--radius-md);box-shadow:var(--shadow-sm);">
        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1.5" style="margin:0 auto 16px;display:block;">
            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
            <circle cx="12" cy="7" r="4"/>
        </svg>
        <h3 style="color:var(--text-medium);margin-bottom:8px;">Belum Ada Data Camat</h3>
        <p style="color:var(--text-light);">Tambahkan data camat untuk ditampilkan di beranda.</p>
    </div>
@endif

<!-- Add Camat Modal -->
<div class="modal-overlay" id="addCamatModal">
    <div class="modal">
        <div class="modal-header">
            <h3>Tambah Camat</h3>
            <button class="modal-close" onclick="closeModal('addCamatModal')">&times;</button>
        </div>
        <form action="{{ route('admin.camat.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Foto Camat <span class="required">*</span></label>
                    <input type="file" name="image" class="form-input" accept="image/*" onchange="previewSingle(this, 'addCamatPreview')" required>
                    <div id="addCamatPreview" class="mt-1"></div>
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Camat <span class="required">*</span></label>
                    <input type="text" name="name" class="form-input" placeholder="Nama lengkap camat" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Jabatan <span class="required">*</span></label>
                    <input type="text" name="position" class="form-input" placeholder="Jabatan camat" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Biografi / Sambutan</label>
                    <textarea name="bio" class="form-textarea" rows="4" placeholder="Tulisan sambutan atau biografi singkat"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('addCamatModal')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Camat Modal -->
<div class="modal-overlay" id="editCamatModal">
    <div class="modal">
        <div class="modal-header">
            <h3>Edit Camat</h3>
            <button class="modal-close" onclick="closeModal('editCamatModal')">&times;</button>
        </div>
        <form id="editCamatForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Foto Camat</label>
                    <div id="editCamatCurrentImg" class="mb-1"></div>
                    <input type="file" name="image" class="form-input" accept="image/*" onchange="previewSingle(this, 'editCamatPreview')">
                    <div id="editCamatPreview" class="mt-1"></div>
                </div>
                <div class="form-group">
                    <label class="form-label">Nama Camat <span class="required">*</span></label>
                    <input type="text" name="name" id="editCamatName" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Jabatan <span class="required">*</span></label>
                    <input type="text" name="position" id="editCamatPosition" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Biografi / Sambutan</label>
                    <textarea name="bio" id="editCamatBio" class="form-textarea" rows="4"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('editCamatModal')">Batal</button>
                <button type="submit" class="btn btn-primary">Perbarui</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(id).classList.add('active');
    }

    function closeModal(id) {
        document.getElementById(id).classList.remove('active');
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

    function openEditCamat(id, name, position, bio, imageUrl) {
        document.getElementById('editCamatForm').action = '{{ url("/admin/camat") }}/' + id;
        document.getElementById('editCamatName').value = name;
        document.getElementById('editCamatPosition').value = position;
        document.getElementById('editCamatBio').value = bio;
        document.getElementById('editCamatCurrentImg').innerHTML = `<img src="${imageUrl}" style="max-width:150px;max-height:120px;border-radius:var(--radius-sm);border:1px solid var(--border-color);" alt="Current">`;
        document.getElementById('editCamatPreview').innerHTML = '';
        openModal('editCamatModal');
    }

    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.remove('active');
            }
        });
    });
</script>

@endsection
