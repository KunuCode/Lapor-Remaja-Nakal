@extends('layouts.admin')

@section('admin-content')

<div class="admin-page-header">
    <h1>Kelola Berita</h1>
    <button class="btn btn-primary" onclick="openModal('addBeritaModal')">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Tambah Berita
    </button>
</div>

@if($news->count() > 0)
    @foreach($news as $item)
        <div class="news-list-item">
            @if($item->images->count() > 0)
                <img src="{{ asset($item->images->first()->image_path) }}" alt="{{ $item->title }}" class="news-list-thumb">
            @else
                <div class="news-list-thumb" style="display:flex;align-items:center;justify-content:center;background:var(--bg-gray);">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1.5">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                        <circle cx="8.5" cy="8.5" r="1.5"/>
                        <polyline points="21 15 16 10 5 21"/>
                    </svg>
                </div>
            @endif
            <div class="news-list-info">
                <h4>{{ $item->title }}</h4>
                <div class="news-list-meta">
                    <span>{{ $item->created_at->format('d/m/Y') }}</span>
                    @if($item->published)
                        <span class="badge badge-published">Dipublikasi</span>
                    @else
                        <span class="badge badge-draft">Draft</span>
                    @endif
                </div>
            </div>
            <div class="news-list-actions">
                <a href="{{ url('/berita/' . $item->id) }}" class="btn btn-outline btn-sm" target="_blank">Lihat</a>
                <button class="btn btn-outline btn-sm" onclick="openEditBerita({{ $item->id }})">Edit</button>
                <form action="{{ route('admin.berita.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus berita ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-destructive btn-sm">Hapus</button>
                </form>
            </div>
        </div>
    @endforeach

    @if($news->hasPages())
        <div class="pagination">
            {{ $news->withQueryString()->links() }}
        </div>
    @endif
@else
    <div style="text-align:center;padding:60px 20px;background:white;border-radius:var(--radius-md);box-shadow:var(--shadow-sm);">
        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1.5" style="margin:0 auto 16px;display:block;">
            <path d="M2 3h6a4 4 0 014 4v14a3 3 0 00-3-3H2z"/>
            <path d="M22 3h-6a4 4 0 00-4 4v14a3 3 0 013-3h7z"/>
        </svg>
        <h3 style="color:var(--text-medium);margin-bottom:8px;">Belum Ada Berita</h3>
        <p style="color:var(--text-light);">Tambahkan berita baru untuk website.</p>
    </div>
@endif

<!-- Add Berita Modal -->
<div class="modal-overlay" id="addBeritaModal">
    <div class="modal" style="max-width:700px;">
        <div class="modal-header">
            <h3>Tambah Berita</h3>
            <button class="modal-close" onclick="closeModal('addBeritaModal')">&times;</button>
        </div>
        <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Judul Berita <span class="required">*</span></label>
                    <input type="text" name="title" class="form-input" placeholder="Masukkan judul berita" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Ringkasan</label>
                    <textarea name="summary" class="form-textarea" rows="2" placeholder="Ringkasan singkat berita"></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Konten Berita <span class="required">*</span></label>
                    <textarea name="content" class="form-textarea" rows="8" placeholder="Isi berita lengkap" required></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Link Eksternal</label>
                    <input type="url" name="link" class="form-input" placeholder="https://example.com (opsional)">
                </div>
                <div class="form-group">
                    <label class="form-label">Gambar Berita</label>
                    <input type="file" name="images[]" class="form-input" accept="image/*" multiple onchange="previewImages(this, 'addBeritaPreview')">
                    <div class="image-preview-grid" id="addBeritaPreview"></div>
                </div>
                <div class="form-group">
                    <label class="d-flex align-center gap-1" style="cursor:pointer;">
                        <input type="checkbox" name="published" value="1" checked style="width:18px;height:18px;">
                        <span class="form-label" style="margin-bottom:0;">Publikasikan</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('addBeritaModal')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Berita Modal -->
<div class="modal-overlay" id="editBeritaModal">
    <div class="modal" style="max-width:700px;">
        <div class="modal-header">
            <h3>Edit Berita</h3>
            <button class="modal-close" onclick="closeModal('editBeritaModal')">&times;</button>
        </div>
        <form id="editBeritaForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-body" id="editBeritaBody">
                <!-- Content loaded via JS -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('editBeritaModal')">Batal</button>
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

    function previewImages(input, previewId) {
        const container = document.getElementById(previewId);
        container.innerHTML = '';
        if (input.files) {
            Array.from(input.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'image-preview-item';
                    div.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                    container.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        }
    }

    function openEditBerita(id) {
        const form = document.getElementById('editBeritaForm');
        form.action = '{{ url("/admin/berita") }}/' + id;

        // Load berita data via fetch
        fetch('{{ url("/berita") }}/' + id)
            .then(response => response.text())
            .then(html => {
                // Parse the HTML response to extract data
                // For simplicity, we'll create the edit form inline
                const body = document.getElementById('editBeritaBody');
                body.innerHTML = `
                    <div class="form-group">
                        <label class="form-label">Judul Berita <span class="required">*</span></label>
                        <input type="text" name="title" class="form-input" placeholder="Masukkan judul berita" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Ringkasan</label>
                        <textarea name="summary" class="form-textarea" rows="2" placeholder="Ringkasan singkat berita"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Konten Berita <span class="required">*</span></label>
                        <textarea name="content" class="form-textarea" rows="8" placeholder="Isi berita lengkap" required></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Link Eksternal</label>
                        <input type="url" name="link" class="form-input" placeholder="https://example.com (opsional)">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tambah Gambar Baru</label>
                        <input type="file" name="images[]" class="form-input" accept="image/*" multiple onchange="previewImages(this, 'editBeritaPreview')">
                        <div class="image-preview-grid" id="editBeritaPreview"></div>
                    </div>
                    <div class="form-group">
                        <label class="d-flex align-center gap-1" style="cursor:pointer;">
                            <input type="checkbox" name="published" value="1" checked style="width:18px;height:18px;">
                            <span class="form-label" style="margin-bottom:0;">Publikasikan</span>
                        </label>
                    </div>
                    <p class="form-help">Catatan: Untuk mengedit konten secara lengkap, harap isi semua field di atas. Data lama akan ditimpa.</p>
                `;
                openModal('editBeritaModal');
            })
            .catch(() => {
                // Fallback: just show the modal with empty form
                document.getElementById('editBeritaBody').innerHTML = `
                    <div class="form-group">
                        <label class="form-label">Judul Berita <span class="required">*</span></label>
                        <input type="text" name="title" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Ringkasan</label>
                        <textarea name="summary" class="form-textarea" rows="2"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Konten Berita <span class="required">*</span></label>
                        <textarea name="content" class="form-textarea" rows="8" required></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Link Eksternal</label>
                        <input type="url" name="link" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tambah Gambar Baru</label>
                        <input type="file" name="images[]" class="form-input" accept="image/*" multiple onchange="previewImages(this, 'editBeritaPreview')">
                        <div class="image-preview-grid" id="editBeritaPreview"></div>
                    </div>
                    <div class="form-group">
                        <label class="d-flex align-center gap-1" style="cursor:pointer;">
                            <input type="checkbox" name="published" value="1" checked style="width:18px;height:18px;">
                            <span class="form-label" style="margin-bottom:0;">Publikasikan</span>
                        </label>
                    </div>
                `;
                openModal('editBeritaModal');
            });
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
