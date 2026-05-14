@extends('layouts.app')

@section('title', 'Berita')

@section('content')

<!-- Page Banner -->
<section class="page-banner">
    <div class="section-container">
        <h1>Berita</h1>
        <p>Informasi terbaru seputar Kecamatan Silaen</p>
    </div>
</section>

<!-- News Grid -->
<section class="section section-gray">
    <div class="section-container">
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
                                <p class="card-text">{{ Str::limit($item->summary, 150) }}</p>
                            @else
                                <p class="card-text">{{ Str::limit(strip_tags($item->content), 150) }}</p>
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

            <!-- Pagination -->
            @if($news->hasPages())
                <div class="pagination">
                    {{ $news->withQueryString()->links() }}
                </div>
            @endif
        @else
            <p class="text-center text-muted">Belum ada berita yang dipublikasikan.</p>
        @endif
    </div>
</section>

@endsection
