@extends('layouts.app')

@section('title', 'Profil')

@section('content')

<!-- Page Banner -->
<section class="page-banner">
    <div class="section-container">
        <h1>Profil Kecamatan Silaen</h1>
        <p>Informasi mengenai Kecamatan Silaen, Kabupaten Toba</p>
    </div>
</section>

<!-- Visi & Misi -->
<section class="section section-white">
    <div class="section-container">
        <div class="profil-section">
            <h2>Visi & Misi</h2>
            @if(isset($visiMisi) && $visiMisi)
                @if($visiMisi->title)
                    <h3 class="mt-2" style="font-size:1.15rem;color:var(--text-dark);">{{ $visiMisi->title }}</h3>
                @endif
                <div class="profil-content">
                    {!! nl2br(e($visiMisi->content)) !!}
                </div>
                @if($visiMisi->image_path)
                    <img src="{{ asset($visiMisi->image_path) }}" alt="Visi & Misi" class="profil-image mt-3">
                @endif
            @else
                <div class="profil-content">
                    <p class="text-muted">Informasi visi dan misi belum tersedia.</p>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Struktur Organisasi -->
<section class="section section-gray">
    <div class="section-container">
        <div class="profil-section">
            <h2>Struktur Organisasi</h2>
            @if(isset($struktur) && $struktur)
                @if($struktur->title)
                    <h3 class="mt-2" style="font-size:1.15rem;color:var(--text-dark);">{{ $struktur->title }}</h3>
                @endif
                <div class="profil-content">
                    {!! nl2br(e($struktur->content)) !!}
                </div>
                @if($struktur->image_path)
                    <img src="{{ asset($struktur->image_path) }}" alt="Struktur Organisasi" class="profil-image mt-3">
                @endif
            @else
                <div class="profil-content">
                    <p class="text-muted">Informasi struktur organisasi belum tersedia.</p>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Tentang Kecamatan -->
<section class="section section-white">
    <div class="section-container">
        <div class="profil-section">
            <h2>Tentang Kecamatan</h2>
            @if(isset($about) && $about)
                @if($about->title)
                    <h3 class="mt-2" style="font-size:1.15rem;color:var(--text-dark);">{{ $about->title }}</h3>
                @endif
                <div class="profil-content">
                    {!! nl2br(e($about->content)) !!}
                </div>
                @if($about->image_path)
                    <img src="{{ asset($about->image_path) }}" alt="Tentang Kecamatan" class="profil-image mt-3">
                @endif
            @else
                <div class="profil-content">
                    <p class="text-muted">Informasi tentang kecamatan belum tersedia.</p>
                </div>
            @endif
        </div>
    </div>
</section>

@endsection