@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

<!-- Hero Section -->
<section class="hero">
    <div class="hero-container">
        <div class="hero-slider" id="heroSlider">
            @forelse($sliders as $index => $slider)
                <img src="{{ asset($slider->image_path) }}" alt="{{ $slider->caption ?? 'Slider' }}" class="{{ $loop->first ? 'active' : '' }}" data-index="{{ $index }}">
            @empty
                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='800' height='500' fill='%23145c2b'%3E%3Crect width='800' height='500'/%3E%3Ctext x='50%25' y='50%25' dominant-baseline='middle' text-anchor='middle' font-family='sans-serif' font-size='24' fill='%23e8f5e9'%3EKecamatan Silaen%3C/text%3E%3C/svg%3E" alt="Default" class="active">
            @endforelse
            <div class="hero-slider-dots" id="sliderDots">
                @forelse($sliders as $index => $slider)
                    <div class="hero-slider-dot {{ $loop->first ? 'active' : '' }}" data-index="{{ $index }}" onclick="goToSlide({{ $index }})"></div>
                @empty
                    <div class="hero-slider-dot active" data-index="0"></div>
                @endforelse
            </div>
        </div>
        <div class="hero-content">
            <h1>Sampaikan Laporan Kenakalan Remaja</h1>
            <p>Platform resmi Pemerintah Kecamatan Silaen, Kabupaten Toba untuk menerima laporan masyarakat terkait kenakalan remaja. Bersama kita ciptakan lingkungan yang aman dan nyaman.</p>
            <div class="hero-buttons">
                @auth
                    <a href="{{ url('/lapor') }}" class="btn btn-white btn-lg">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="12" y1="11" x2="12" y2="17"/>
                            <line x1="9" y1="14" x2="15" y2="14"/>
                        </svg>
                        Buat Laporan
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-white btn-lg">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="12" y1="11" x2="12" y2="17"/>
                            <line x1="9" y1="14" x2="15" y2="14"/>
                        </svg>
                        Buat Laporan
                    </a>
                @endauth
                <a href="{{ url('/profil') }}" class="btn btn-outline btn-lg" style="color:white;border-color:white;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="16" x2="12" y2="12"/>
                        <line x1="12" y1="8" x2="12.01" y2="8"/>
                    </svg>
                    Tentang Kami
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Camat Section -->
@if(isset($camat) && $camat)
<section class="section section-white">
    <div class="section-container">
        <div class="section-header">
            <h2>Sambutan Camat</h2>
            <div class="section-header-line"></div>
        </div>
        <div class="camat-section">
            <div class="camat-photo-wrapper">
                <img src="{{ asset($camat->image_path) }}" alt="{{ $camat->name }}" class="camat-photo">
            </div>
            <div class="camat-info">
                <h3>{{ $camat->name }}</h3>
                <p class="camat-position">{{ $camat->position }}</p>
                @if($camat->bio)
                    <p class="camat-bio">{{ $camat->bio }}</p>
                @endif
            </div>
        </div>
    </div>
</section>
@endif

<!-- Latest News Section -->
<section class="section section-gray">
    <div class="section-container">
        <div class="section-header">
            <h2>Berita Terbaru</h2>
            <div class="section-header-line"></div>
        </div>
        @if($news->count() > 0)
            <div class="grid-3">
                @foreach($news as $item)
                    <div class="card">
                        @if($item->images->count() > 0)
                            <img src="{{ asset($item->images->first()->image_path) }}" alt="{{ $item->title }}" class="card-img">
                        @else
                            <div class="card-img" style="background:var(--bg-gray);display:flex;align-items:center;justify-content:center;">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1.5">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                    <circle cx="8.5" cy="8.5" r="1.5"/>
                                    <polyline points="21 15 16 10 5 21"/>
                                </svg>
                            </div>
                        @endif
                        <div class="card-body">
                            <p class="card-date">{{ $item->created_at->format('d F Y') }}</p>
                            <h3 class="card-title">{{ $item->title }}</h3>
                            @if($item->summary)
                                <p class="card-text">{{ Str::limit($item->summary, 120) }}</p>
                            @else
                                <p class="card-text">{{ Str::limit(strip_tags($item->content), 120) }}</p>
                            @endif
                            <a href="{{ url('/berita/' . $item->id) }}" class="card-link">
                                Baca Selengkapnya
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="9 18 15 12 9 6"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-muted">Belum ada berita yang dipublikasikan.</p>
        @endif
    </div>
</section>

<!-- Alur Pelaporan Section -->
<section class="section section-white">
    <div class="section-container">
        <div class="section-header">
            <h2>Alur Pelaporan</h2>
            <div class="section-header-line"></div>
        </div>
        <div class="alur-steps">
            <!-- Step 1 -->
            <div class="alur-step">
                <div class="alur-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="12" y1="11" x2="12" y2="17"/>
                        <line x1="9" y1="14" x2="15" y2="14"/>
                    </svg>
                </div>
                <p class="alur-title">Buat Laporan</p>
                <p class="alur-desc">Isi formulir laporan kenakalan remaja</p>
            </div>
            <!-- Step 2 -->
            <div class="alur-step">
                <div class="alur-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 12l2 2 4-4"/>
                        <path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="alur-title">Verifikasi Admin</p>
                <p class="alur-desc">Admin memverifikasi laporan Anda</p>
            </div>
            <!-- Step 3 -->
            <div class="alur-step">
                <div class="alur-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15 3 21 3 21 9"/>
                        <path d="M21 3l-7 7"/>
                        <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/>
                    </svg>
                </div>
                <p class="alur-title">Ditindaklanjuti</p>
                <p class="alur-desc">Laporan ditindaklanjuti oleh pihak berwenang</p>
            </div>
            <!-- Step 4 -->
            <div class="alur-step">
                <div class="alur-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                </div>
                <p class="alur-title">Selesai</p>
                <p class="alur-desc">Permasalahan telah diselesaikan</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="section section-green">
    <div class="section-container">
        <div class="cta-banner">
            <h2>Punya Informasi Kenakalan Remaja?</h2>
            <p>Sampaikan laporan Anda dan bantu kami menciptakan lingkungan yang lebih baik untuk generasi muda Kecamatan Silaen.</p>
            @auth
                <a href="{{ url('/lapor') }}" class="btn btn-white btn-lg">Buat Laporan Sekarang</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-white btn-lg">Buat Laporan Sekarang</a>
            @endauth
        </div>
    </div>
</section>

<script>
    // Auto-sliding carousel
    (function() {
        const images = document.querySelectorAll('#heroSlider img');
        const dots = document.querySelectorAll('#sliderDots .hero-slider-dot');
        let currentSlide = 0;
        const totalSlides = images.length;

        if (totalSlides <= 1) return;

        function showSlide(index) {
            images.forEach(img => img.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));

            if (images[index]) images[index].classList.add('active');
            if (dots[index]) dots[index].classList.add('active');
            currentSlide = index;
        }

        window.goToSlide = function(index) {
            showSlide(index);
        };

        setInterval(() => {
            currentSlide = (currentSlide + 1) % totalSlides;
            showSlide(currentSlide);
        }, 5000);
    })();
</script>
@endsection
