@extends('layouts.admin')

@section('admin-content')

<div class="admin-page-header">
    <h1>Kelola Slider</h1>
    <button class="btn btn-primary" onclick="openModal('addSliderModal')">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        Tambah Slider
    </button>
</div>

<p class="form-help mb-3" style="font-size:0.88rem;">Anda bisa mengunggah lebih dari 10 foto slider.</p>

@if($sliders->count() > 0)
    <div class="slider-grid">
        @foreach($sliders as $slider)
            <div class="slider-card">
                <img src="{{ asset($slider->image_path) }}" alt="{{ $slider->caption ?? 'Slider' }}" class="slider-card-img">
                <div class="slider-card-body">
                    <p class="slider-card-caption">{{ $slider->caption ?? 'Tanpa keterangan' }}</p>
                    <p class="slider-card-order">Urutan: {{ $slider->order }} &bull; Status: {{ $slider->active ? 'Aktif' : 'Nonaktif' }}</p>
                    <div class="slider-card-actions">
                        <form action="{{ route('admin.slider.toggle', $slider->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <label class="toggle-switch">
                                <input type="checkbox" {{ $slider->active ? 'checked' : '' }} onchange="this.form.submit()">
                                <span class="toggle-slider"></span>
                            </label>
                        </form>
                        <button class="btn btn-outline btn-sm" onclick="openEditSlider({{ $slider->id }}, '{{ addslashes($slider->caption ?? '') }}', {{ $slider->order }}, '{{ asset($slider->image_path) }}')">Edit</button>
                        <form action="{{ route('admin.slider.destroy', $slider->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus slider ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-destructive btn-sm">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div style="text-align:center;padding:60px 20px;background:white;border-radius:var(--radius-md);box-shadow:var(--shadow-sm);">
        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1.5" style="margin:0 auto 16px;display:block;">
            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
            <circle cx="8.5" cy="8.5" r="1.5"/>
            <polyline points="21 15 16 10 5 21"/>
        </svg>
        <h3 style="color:var(--text-medium);margin-bottom:8px;">Belum Ada Slider</h3>
        <p style="color:var(--text-light);">Tambahkan foto slider untuk halaman beranda.</p>
    </div>
@endif

<!-- Add Slider Modal -->
<div class="modal-overlay" id="addSliderModal">
    <div class="modal">
        <div class="modal-header">
            <h3>Tambah Slider</h3>
            <button class="modal-close" onclick="closeModal('addSliderModal')">&times;</button>
        </div>
        <form action="{{ route('admin.slider.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Gambar Slider</label>
                    <input type="file" name="image" class="form-input" accept="image/*" onchange="previewSingle(this, 'addSliderPreview')">
                    <div id="addSliderPreview" class="mt-1"></div>
                </div>
                <div class="form-group">
                    <label class="form-label">Keterangan</label>
                    <input type="text" name="caption" class="form-input" placeholder="Keterangan slider (opsional)">
                </div>
                <div class="form-group">
                    <label class="form-label">Urutan</label>
                    <input type="number" name="order" class="form-input" value="0" min="0">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('addSliderModal')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Slider Modal -->
<div class="modal-overlay" id="editSliderModal">
    <div class="modal">
        <div class="modal-header">
            <h3>Edit Slider</h3>
            <button class="modal-close" onclick="closeModal('editSliderModal')">&times;</button>
        </div>
        <form id="editSliderForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Gambar Slider</label>
                    <div id="editSliderCurrentImg" class="mb-1"></div>
                    <input type="file" name="image" class="form-input" accept="image/*" onchange="previewSingle(this, 'editSliderPreview')">
                    <div id="editSliderPreview" class="mt-1"></div>
                </div>
                <div class="form-group">
                    <label class="form-label">Keterangan</label>
                    <input type="text" name="caption" id="editSliderCaption" class="form-input" placeholder="Keterangan slider (opsional)">
                </div>
                <div class="form-group">
                    <label class="form-label">Urutan</label>
                    <input type="number" name="order" id="editSliderOrder" class="form-input" min="0">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('editSliderModal')">Batal</button>
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

    function openEditSlider(id, caption, order, imageUrl) {
        document.getElementById('editSliderForm').action = '{{ url("/admin/slider") }}/' + id;
        document.getElementById('editSliderCaption').value = caption;
        document.getElementById('editSliderOrder').value = order;
        document.getElementById('editSliderCurrentImg').innerHTML = `<img src="${imageUrl}" style="max-width:200px;max-height:150px;border-radius:var(--radius-sm);border:1px solid var(--border-color);" alt="Current">`;
        document.getElementById('editSliderPreview').innerHTML = '';
        openModal('editSliderModal');
    }

    // Close modal on overlay click
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.remove('active');
            }
        });
    });
</script>

@endsection
