@extends('layouts.app')

@section('title', 'Buat Laporan')

@section('content')

<!-- Hero Banner -->
<section class="page-banner">
    <div class="section-container">
        <h1>Buat Laporan</h1>
        <p>Sampaikan informasi kenakalan remaja di wilayah Kecamatan Silaen</p>
    </div>
</section>

<!-- Report Form -->
<section class="section section-gray">
    <div class="section-container">
        <div style="max-width:700px;margin:0 auto;">
            <form action="{{ route('lapor.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div style="background:white;padding:32px;border-radius:var(--radius-lg);box-shadow:var(--shadow-sm);">
                    <h2 style="font-size:1.25rem;font-weight:700;color:var(--text-dark);margin-bottom:24px;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" style="vertical-align:middle;margin-right:8px;">
                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="12" y1="11" x2="12" y2="17"/>
                            <line x1="9" y1="14" x2="15" y2="14"/>
                        </svg>
                        Formulir Laporan
                    </h2>

                    <!-- Judul Laporan -->
                    <div class="form-group">
                        <label class="form-label">Judul Laporan <span class="required">*</span></label>
                        <input type="text" name="title" class="form-input {{ $errors->has('title') ? 'is-error' : '' }}" value="{{ old('title') }}" placeholder="Masukkan judul laporan">
                        @error('title')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                        <input type="text" name="name" class="form-input {{ $errors->has('name') ? 'is-error' : '' }}" value="{{ old('name', auth()->user()->name ?? '') }}" placeholder="Nama lengkap Anda">
                        @error('name')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label class="form-label">Email <span class="required">*</span></label>
                        <input type="email" name="email" class="form-input {{ $errors->has('email') ? 'is-error' : '' }}" value="{{ old('email', auth()->user()->email ?? '') }}" placeholder="email@contoh.com">
                        @error('email')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- No HP -->
                    <div class="form-group">
                        <label class="form-label">No HP <span class="required">*</span></label>
                        <input type="text" name="phone" class="form-input {{ $errors->has('phone') ? 'is-error' : '' }}" value="{{ old('phone', auth()->user()->phone ?? '') }}" placeholder="08xxxxxxxxxx">
                        @error('phone')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kategori Kejadian -->
                    <div class="form-group">
                        <label class="form-label">Kategori Kejadian <span class="required">*</span></label>
                        <select name="category" class="form-select {{ $errors->has('category') ? 'is-error' : '' }}">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Begal" {{ old('category') == 'Begal' ? 'selected' : '' }}>Begal</option>
                            <option value="Tawuran" {{ old('category') == 'Tawuran' ? 'selected' : '' }}>Tawuran</option>
                            <option value="Mabuk" {{ old('category') == 'Mabuk' ? 'selected' : '' }}>Mabuk</option>
                            <option value="Merusak Fasilitas" {{ old('category') == 'Merusak Fasilitas' ? 'selected' : '' }}>Merusak Fasilitas</option>
                            <option value="Pencurian" {{ old('category') == 'Pencurian' ? 'selected' : '' }}>Pencurian</option>
                            <option value="Perkelahian" {{ old('category') == 'Perkelahian' ? 'selected' : '' }}>Perkelahian</option>
                            <option value="Lainnya" {{ old('category') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('category')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Desa -->
                    <div class="form-group">
                        <label class="form-label">Nama Desa <span class="required">*</span></label>
                        <input type="text" name="village" class="form-input {{ $errors->has('village') ? 'is-error' : '' }}" value="{{ old('village') }}" placeholder="Nama desa/kelurahan kejadian">
                        @error('village')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Alamat Lengkap -->
                    <div class="form-group">
                        <label class="form-label">Alamat Lengkap <span class="required">*</span></label>
                        <textarea name="address" class="form-textarea {{ $errors->has('address') ? 'is-error' : '' }}" rows="3" placeholder="Masukkan alamat lengkap lokasi kejadian">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi Kejadian -->
                    <div class="form-group">
                        <label class="form-label">Deskripsi Kejadian <span class="required">*</span></label>
                        <textarea name="description" class="form-textarea {{ $errors->has('description') ? 'is-error' : '' }}" rows="5" placeholder="Jelaskan detail kejadian yang Anda laporkan">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Upload Foto Kejadian -->
                    <div class="form-group">
                        <label class="form-label">Upload Foto Kejadian</label>
                        <div class="file-upload-area" onclick="document.getElementById('imageInput').click()">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                <polyline points="21 15 16 10 5 21"/>
                            </svg>
                            <p>Klik untuk memilih foto atau seret file ke sini</p>
                            <small>Format: JPG, PNG, GIF (Maks. 2MB per file)</small>
                        </div>
                        <input type="file" name="images[]" id="imageInput" multiple accept="image/*" onchange="previewImages(this, 'imagePreview')" style="display:none;">
                        <div class="image-preview-grid" id="imagePreview"></div>
                        @error('images.*')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group" style="margin-bottom:0;">
                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="22" y1="2" x2="11" y2="13"/>
                                <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                            </svg>
                            Kirim Laporan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection
