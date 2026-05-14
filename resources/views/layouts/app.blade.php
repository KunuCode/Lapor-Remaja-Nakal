<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lapor Remaja Nakal - @yield('title', 'Kecamatan Silaen')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $siteLogo = \App\Models\SiteSetting::where('key', 'site_logo')->value('value');
        $siteFavicon = \App\Models\SiteSetting::where('key', 'site_favicon')->value('value');
        $siteName = \App\Models\SiteSetting::where('key', 'site_name')->value('value') ?? 'Lapor Remaja Nakal';
    @endphp
    @if($siteFavicon)
        <link rel="icon" type="image/png" href="{{ asset($siteFavicon) }}">
    @endif
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')

    @auth
    @if(auth()->user()->isAdmin())
    <style>
        .notif-wrapper {
            position: relative;
            display: inline-flex;
            align-items: center;
        }

        .notif-bell-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 2px solid rgba(255,255,255,0.3);
            background: transparent;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
            margin-left: 6px;
            color: inherit;
        }

        .notif-bell-btn:hover {
            background: rgba(255,255,255,0.15);
            border-color: rgba(255,255,255,0.5);
        }

        .notif-bell-btn svg {
            width: 18px;
            height: 18px;
        }

        .notif-bell-btn .notif-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background: #dc3545;
            color: #fff;
            border-radius: 50%;
            min-width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.6rem;
            font-weight: 700;
            border: 2px solid;
            padding: 0;
            line-height: 1;
        }

        .notif-bell-btn .notif-badge.hidden {
            display: none;
        }

        .notif-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            width: 360px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.18);
            z-index: 9999;
            display: none;
            overflow: hidden;
            color: #333;
        }

        .notif-dropdown.show {
            display: block;
            animation: notifSlideDown 0.2s ease-out;
        }

        @keyframes notifSlideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .notif-dropdown .nd-header {
            padding: 12px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
            background: #fafafa;
        }

        .notif-dropdown .nd-header h6 {
            margin: 0;
            font-weight: 700;
            font-size: 0.9rem;
            color: #333;
        }

        .notif-dropdown .nd-header .mark-all-btn {
            background: none;
            border: none;
            color: #1a7a3a;
            font-size: 0.75rem;
            cursor: pointer;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 4px;
        }

        .notif-dropdown .nd-header .mark-all-btn:hover {
            background: #e8f5e9;
        }

        .notif-dropdown .nd-body {
            max-height: 320px;
            overflow-y: auto;
        }

        .notif-dropdown .nd-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 12px 16px;
            border-bottom: 1px solid #f5f5f5;
            cursor: pointer;
            transition: background 0.15s;
            text-decoration: none;
            color: inherit;
        }

        .notif-dropdown .nd-item:hover {
            background: #f0f7f0;
        }

        .notif-dropdown .nd-item:last-child {
            border-bottom: none;
        }

        .nd-item .nd-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #fff3e0;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .nd-item .nd-icon svg {
            width: 18px;
            height: 18px;
            color: #f57c00;
        }

        .nd-item .nd-content {
            flex: 1;
            min-width: 0;
        }

        .nd-item .nd-title {
            font-weight: 600;
            font-size: 0.82rem;
            color: #222;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .nd-item .nd-text {
            font-size: 0.75rem;
            color: #666;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .nd-item .nd-time {
            font-size: 0.7rem;
            color: #999;
        }

        .notif-dropdown .nd-footer {
            padding: 10px 16px;
            text-align: center;
            border-top: 1px solid #eee;
            background: #fafafa;
        }

        .notif-dropdown .nd-footer a {
            color: #1a7a3a;
            font-weight: 600;
            font-size: 0.82rem;
            text-decoration: none;
        }

        .notif-dropdown .nd-footer a:hover {
            text-decoration: underline;
        }

        .notif-dropdown .nd-empty {
            padding: 25px 16px;
            text-align: center;
        }

        .notif-dropdown .nd-empty svg {
            width: 32px;
            height: 32px;
            color: #ddd;
            margin-bottom: 8px;
        }

        .notif-dropdown .nd-empty p {
            color: #999;
            font-size: 0.82rem;
            margin: 0;
        }

        .mobile-notif-btn .notif-badge-mobile {
            background: #dc3545;
            color: #fff;
            border-radius: 10px;
            padding: 2px 8px;
            font-size: 0.7rem;
            font-weight: 700;
        }

        .mobile-notif-btn .notif-badge-mobile.hidden {
            display: none;
        }
    </style>
    @endif
    @endauth
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ url('/') }}" class="navbar-brand">
                @if($siteLogo && file_exists(public_path($siteLogo)))
                    <img src="{{ asset($siteLogo) }}" alt="{{ $siteName }}" style="height:38px;width:auto;border-radius:4px;">
                @else
                    <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 2L4 10v12c0 9.6 6.8 18.4 16 20 9.2-1.6 16-10.4 16-20V10L20 2z" fill="#1a7a3a"/>
                        <path d="M20 5L7 11.4v10.2c0 7.8 5.5 15 13 16.4 7.5-1.4 13-8.6 13-16.4V11.4L20 5z" fill="#e8f5e9"/>
                        <path d="M20 8L10 12.8v8.4c0 6.2 4.3 11.8 10 13 5.7-1.2 10-6.8 10-13v-8.4L20 8z" fill="#1a7a3a"/>
                        <path d="M15 20l3 3 7-7" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                @endif
                <div class="navbar-brand-text">
                    <span class="navbar-brand-title">{{ $siteName }}</span>
                    <span class="navbar-brand-subtitle">Kecamatan Silaen, Kabupaten Toba</span>
                </div>
            </a>

            <ul class="navbar-links">
                <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Beranda</a></li>
                <li><a href="{{ url('/profil') }}" class="{{ request()->is('profil') ? 'active' : '' }}">Profil</a></li>
                <li><a href="{{ url('/berita') }}" class="{{ request()->is('berita') ? 'active' : '' }}">Berita</a></li>
                <li><a href="{{ url('/lapor') }}" class="{{ request()->is('lapor') ? 'active' : '' }}">Lapor</a></li>

                <!-- NOTIFIKASI BELL (Hanya Admin) -->
                @auth
                @if(auth()->user()->isAdmin())
                <li class="notif-wrapper">
                    <button class="notif-bell-btn" onclick="toggleNotifDropdown()" title="Laporan Masuk">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                            <path d="M13.73 21a2 2 0 01-3.46 0"/>
                        </svg>
                        <span class="notif-badge hidden" id="notifBadge">0</span>
                    </button>
                    <div class="notif-dropdown" id="notifDropdown">
                        <div class="nd-header">
                            <h6>Laporan Masuk Baru</h6>
                            <button class="mark-all-btn" id="markAllReadBtn" onclick="markAllAsRead()">Tandai semua dibaca</button>
                        </div>
                        <div class="nd-body" id="notifList">
                            <div class="nd-empty">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                                    <path d="M13.73 21a2 2 0 01-3.46 0"/>
                                    <line x1="1" y1="1" x2="23" y2="23"/>
                                </svg>
                                <p>Tidak ada laporan baru</p>
                            </div>
                        </div>
                        <div class="nd-footer">
                            <a href="{{ route('admin.laporan.index') }}">Lihat Semua Laporan</a>
                        </div>
                    </div>
                </li>
                @endif
                @endauth
            </ul>

            <div class="navbar-actions">
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ url('/admin') }}" class="btn btn-primary btn-sm">Dashboard Admin</a>
                    @else
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-sm">Dashboard</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-outline btn-sm">Keluar</button>
                    </form>
                @endauth
                @guest
                    <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Masuk</a>
                @endguest
            </div>

            <button class="hamburger" onclick="toggleMobileMenu()" aria-label="Menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <a href="{{ url('/') }}">Beranda</a>
        <a href="{{ url('/profil') }}">Profil</a>
        <a href="{{ url('/berita') }}">Berita</a>
        @auth
            <a href="{{ url('/lapor') }}">Lapor</a>

            @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.laporan.index') }}" class="mobile-notif-btn">
                🔔 Laporan Masuk
                <span class="notif-badge-mobile hidden" id="notifBadgeMobile">0</span>
            </a>
            @endif

            @if(auth()->user()->isAdmin())
                <a href="{{ url('/admin') }}">Dashboard Admin</a>
            @else
                <a href="{{ url('/dashboard') }}">Dashboard</a>
            @endif
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-outline btn-block mt-2">Keluar</button>
            </form>
        @endauth
        @guest
            <a href="{{ route('login') }}" class="btn btn-primary btn-block mt-2">Masuk</a>
        @endguest
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success" style="max-width:1200px;margin:16px auto 0;padding-left:20px;padding-right:20px;">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor" style="flex-shrink:0;margin-top:2px;">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error" style="max-width:1200px;margin:16px auto 0;padding-left:20px;padding-right:20px;">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor" style="flex-shrink:0;margin-top:2px;">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div>
                <h4>Informasi</h4>
                <p>Sistem Pelaporan Kenakalan Remaja merupakan platform resmi Pemerintah Kecamatan Silaen, Kabupaten Toba untuk menerima dan menindaklanjuti laporan masyarakat terkait kenakalan remaja di wilayah Kecamatan Silaen.</p>
            </div>
            <div>
                <h4>Tautan</h4>
                <ul class="footer-links">
                    <li><a href="{{ url('/') }}">Beranda</a></li>
                    <li><a href="{{ url('/profil') }}">Profil</a></li>
                    <li><a href="{{ url('/berita') }}">Berita</a></li>
                    @auth
                        <li><a href="{{ url('/lapor') }}">Buat Laporan</a></li>
                    @endauth
                </ul>
            </div>
            <div>
                <h4>Kontak</h4>
                <div class="footer-contact-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                    <span>Kecamatan Silaen, Kabupaten Toba, Sumatera Utara</span>
                </div>
                <div class="footer-contact-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/>
                    </svg>
                    <span>(0625) 123456</span>
                </div>
                <div class="footer-contact-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <polyline points="22,6 12,13 2,6"/>
                    </svg>
                    <span>info@silaenkab.toba.go.id</span>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Pemerintah Kecamatan Silaen, Kabupaten Toba. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            const hamburger = document.querySelector('.hamburger');
            menu.classList.toggle('active');
            hamburger.classList.toggle('active');
        }

        document.querySelectorAll('.mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                document.getElementById('mobileMenu').classList.remove('active');
                document.querySelector('.hamburger').classList.remove('active');
            });
        });

        function previewImages(input, previewContainer) {
            const container = document.getElementById(previewContainer);
            if (!container) return;
            container.innerHTML = '';
            if (input.files) {
                Array.from(input.files).forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'image-preview-item';
                        div.innerHTML = '<img src="' + e.target.result + '" alt="Preview"><button type="button" class="image-preview-remove" onclick="removePreview(this, ' + index + ')">&times;</button>';
                        container.appendChild(div);
                    };
                    reader.readAsDataURL(file);
                });
            }
        }

        document.querySelectorAll('.alert').forEach(alert => {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }, 5000);
        });
    </script>

    <!-- NOTIFIKASI SCRIPT (Hanya Admin) -->
    @auth
    @if(auth()->user()->isAdmin())
    <script>
        const notifBadge = document.getElementById('notifBadge');
        const notifBadgeMobile = document.getElementById('notifBadgeMobile');
        const notifList = document.getElementById('notifList');
        const notifDropdown = document.getElementById('notifDropdown');
        const markAllBtn = document.getElementById('markAllReadBtn');

        function fetchNotifCount() {
            fetch('{{ route("admin.notifikasi.count") }}')
                .then(res => res.json())
                .then(data => {
                    const count = data.count;
                    if (count > 0) {
                        if (notifBadge) {
                            notifBadge.textContent = count > 99 ? '99+' : count;
                            notifBadge.classList.remove('hidden');
                        }
                        if (notifBadgeMobile) {
                            notifBadgeMobile.textContent = count > 99 ? '99+' : count;
                            notifBadgeMobile.classList.remove('hidden');
                        }
                    } else {
                        if (notifBadge) notifBadge.classList.add('hidden');
                        if (notifBadgeMobile) notifBadgeMobile.classList.add('hidden');
                    }
                })
                .catch(err => console.error('Error:', err));
        }

        function fetchNotifList() {
            fetch('{{ route("admin.notifikasi.latest") }}')
                .then(res => res.json())
                .then(data => {
                    const reports = data.reports;
                    if (reports.length === 0) {
                        notifList.innerHTML = '<div class="nd-empty"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/><line x1="1" y1="1" x2="23" y2="23"/></svg><p>Tidak ada laporan baru</p></div>';
                        markAllBtn.style.display = 'none';
                        return;
                    }
                    markAllBtn.style.display = 'inline-block';
                    let html = '';
                    reports.forEach(report => {
                        const url = '{{ route("admin.laporan.show", ["id" => "__ID__"]) }}'.replace('__ID__', report.id);
                        html += '<a href="' + url + '" class="nd-item" onclick="markAsRead(' + report.id + ')">'
                            + '<div class="nd-icon">'
                            + '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>'
                            + '</div>'
                            + '<div class="nd-content">'
                            + '<div class="nd-title">' + report.judul + '</div>'
                            + '<div class="nd-text">Kategori: ' + report.kategori + ' — Lokasi: ' + report.lokasi + '</div>'
                            + '<div class="nd-time">' + report.waktu + '</div>'
                            + '</div></a>';
                    });
                    notifList.innerHTML = html;
                })
                .catch(err => console.error('Error:', err));
        }

        function toggleNotifDropdown() {
            notifDropdown.classList.toggle('show');
            if (notifDropdown.classList.contains('show')) {
                fetchNotifList();
            }
        }

        function markAsRead(id) {
            const url = '{{ route("admin.notifikasi.markRead", ["id" => "__ID__"]) }}'.replace('__ID__', id);
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(() => fetchNotifCount())
              .catch(err => console.error('Error:', err));
        }

        function markAllAsRead() {
            fetch('{{ route("admin.notifikasi.markAllRead") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(() => {
                fetchNotifCount();
                fetchNotifList();
            }).catch(err => console.error('Error:', err));
        }

        document.addEventListener('click', function(e) {
            const wrapper = document.querySelector('.notif-wrapper');
            if (wrapper && !wrapper.contains(e.target)) {
                notifDropdown.classList.remove('show');
            }
        });

        fetchNotifCount();
        setInterval(fetchNotifCount, 30000);
    </script>
    @endif
    @endauth

    @stack('scripts')
</body>
</html>