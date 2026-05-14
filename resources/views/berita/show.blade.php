@extends('layouts.app')

@section('title', $news->title)

@section('content')

<section class="section section-gray">
    <div class="section-container">
        <div class="berita-show">
            <!-- Back Link -->
            <a href="{{ url('/berita') }}" class="back-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="19" y1="12" x2="5" y2="12"/>
                    <polyline points="12 19 5 12 12 5"/>
                </svg>
                Kembali ke Daftar Berita
            </a>

            <!-- Header -->
            <div class="berita-show-header">
                <h1>{{ $news->title }}</h1>
                <p class="berita-show-date">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:middle;margin-right:4px;">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    {{ $news->created_at->format('d F Y') }}
                </p>
            </div>

            <!-- Image Gallery -->
            @if($news->images->count() > 0)
                <div class="berita-gallery">
                    @foreach($news->images as $image)
                        <img src="{{ asset($image->image_path) }}" alt="{{ $news->title }}">
                    @endforeach
                </div>
            @endif

            <!-- Content -->
            <div class="berita-content">
                {!! nl2br(e($news->content)) !!}
            </div>

            <!-- External Link -->
            @if($news->link)
                <a href="{{ $news->link }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline mb-3">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/>
                        <polyline points="15 3 21 3 21 9"/>
                        <line x1="10" y1="14" x2="21" y2="3"/>
                    </svg>
                    Lihat Sumber Berita
                </a>
            @endif
        </div>
    </div>
</section>

@endsection
