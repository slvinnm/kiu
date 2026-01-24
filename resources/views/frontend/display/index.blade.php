@extends('frontend.layouts.main')

@section('title', 'Antrian Display')

@section('css')
    <style>
        :root {
            --bg-dark: #020617;
            --panel-bg: #0f172a;
            --accent: #3b82f6;
            --accent-gradient: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            --highlight: #facc15;
            --text-light: #f8fafc;
            --text-dim: #94a3b8;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-light);
            height: 100vh;
            overflow: hidden;
            margin: 0;
        }

        .broadcast-grid {
            display: grid;
            grid-template-columns: 1fr 550px;
            grid-template-rows: 90px 1fr;
            height: 100vh;
            width: 100vw;
        }

        .header-section {
            grid-column: 1 / -1;
            background: var(--panel-bg);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            z-index: 10;
        }

        .brand-wrapper {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .brand-logo {
            width: 50px;
            height: 50px;
            object-fit: contain;
            filter: drop-shadow(0 0 5px rgba(59, 130, 246, 0.5));
        }

        .company-name {
            font-size: 1.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: white;
        }

        .clock-wrapper {
            text-align: right;
            line-height: 1;
        }

        .clock-display {
            font-family: 'Oswald', sans-serif;
            font-size: 2.5rem;
            color: var(--highlight);
            font-weight: 500;
            text-shadow: 0 0 10px rgba(250, 204, 21, 0.3);
        }

        .date-display {
            font-size: 1rem;
            color: var(--text-dim);
            font-weight: 500;
            margin-top: 4px;
        }

        .status-text {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.9rem;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
            background: #f1f5f9;
            padding: 8px 20px;
            border-radius: 50px;
        }

        .pulse-dot {
            width: 10px;
            height: 10px;
            background: #22c55e;
            border-radius: 50%;
            animation: pulse 1.5s infinite;
        }

        .left-column {
            grid-row: 2 / 3;
            grid-column: 1 / 2;
            padding: 20px;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .media-card {
            background: #000;
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
            height: 100%;
            display: flex;
            flex-direction: column;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .media-content {
            flex-grow: 1;
            position: relative;
            background: #000;
            overflow: hidden;
        }

        .media-content video,
        .media-content img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card-footer-ticker {
            height: 60px;
            background: var(--panel-bg);
            display: flex;
            align-items: center;
        }

        .ticker-label {
            background: var(--accent);
            color: #fff;
            font-weight: 700;
            padding: 0 40px;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .ticker-text {
            color: #fff;
            font-size: 1.25rem;
            font-weight: 400;
            padding-left: 20px;
            letter-spacing: 0.5px;
        }

        .right-column {
            grid-row: 2 / 3;
            grid-column: 2 / 3;
            background: var(--panel-bg);
            border-left: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            flex-direction: column;
            padding: 20px;
            gap: 20px;
        }

        .active-ticket-card {
            background: var(--accent-gradient);
            border-radius: 20px;
            padding: 0;
            text-align: center;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: visible;
            box-shadow: 0 20px 40px -10px rgba(59, 130, 246, 0.6);
            position: relative;
            mask-image: radial-gradient(circle at 0% 65%, transparent 20px, black 21px),
                radial-gradient(circle at 100% 65%, transparent 20px, black 21px);
            mask-composite: intersect;
            -webkit-mask-image: radial-gradient(circle at 0 65%, transparent 15px, black 16px),
                radial-gradient(circle at 100% 65%, transparent 15px, black 16px);
            -webkit-mask-composite: source-in;
        }

        .ticket-header {
            padding: 30px 20px 40px 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .status-pill {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.4);
            padding: 8px 20px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .ticket-label {
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 5px;
            font-weight: 600;
        }

        .ticket-number {
            font-family: 'Oswald', sans-serif;
            font-weight: 700;
            line-height: 1;
            color: #fff;
            word-break: break-word;
            text-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .destination-area {
            background: rgba(0, 0, 0, 0.15);
            padding: 35px 20px 25px 20px;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            position: relative;
        }

        .destination-area::before {
            content: '';
            position: absolute;
            top: 0;
            left: 20px;
            right: 20px;
            height: 0;
            border-top: 3px dashed rgba(255, 255, 255, 0.4);
        }

        .service-name {
            font-weight: 700;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 1px;
            line-height: 1.2;
            width: 100%;
            word-wrap: break-word;
        }

        .counter-badge {
            background: #fff;
            color: var(--accent);
            font-size: 1.8rem;
            font-weight: 800;
            padding: 12px 30px;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 90%;
        }

        .location-text {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .history-ticket-card {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 16px;
            padding: 20px;
            flex-shrink: 0;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .history-header {
            color: var(--text-dim);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .history-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .history-item:last-child {
            border-bottom: none;
        }

        .h-num {
            font-family: 'Oswald', sans-serif;
            color: var(--text-light);
            font-size: 1.5rem;
        }

        .h-details {
            text-align: right;
        }

        .h-service {
            display: block;
            font-size: 0.75rem;
            color: var(--text-dim);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .h-counter {
            display: block;
            color: var(--highlight);
            font-weight: 500;
            font-size: 1rem;
        }

        .flash-overlay {
            position: fixed;
            inset: 0;
            background: var(--accent);
            z-index: 9999;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            animation: flashBg 0.5s infinite alternate;
        }

        .start-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 10000;
            background-color: var(--panel-bg);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
        }

        .start-icon {
            font-size: 5rem;
            color: var(--accent);
            margin-bottom: 1rem;
        }

        .start-title {
            font-size: 2.25rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .start-subtitle {
            color: var(--text-dim);
            margin-bottom: 2rem;
        }

        .start-btn {
            padding: 1rem 2rem;
            background-color: var(--accent);
            color: white;
            font-weight: 700;
            border-radius: 9999px;
            font-size: 1.25rem;
            border: none;
            cursor: pointer;
            transition: transform 0.2s, background-color 0.2s;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
            display: inline-flex;
            align-items: center;
        }

        .start-btn:hover {
            background-color: #1d4ed8;
            transform: scale(1.05);
        }

        .fade-enter-active,
        .fade-leave-active {
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .fade-enter-start,
        .fade-leave-end {
            opacity: 0;
            transform: scale(0.9);
        }

        .fade-enter-end,
        .fade-leave-start {
            opacity: 1;
            transform: scale(1);
        }

        /* Add inside your <style> tag */

        /* Style for when there is no active ticket (Waiting Mode) */
        .idle-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: rgba(255, 255, 255, 0.5);
            text-align: center;
            animation: fadeIn 0.5s ease-in;
        }

        .idle-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: rgba(255, 255, 255, 0.3);
        }

        .idle-text {
            font-size: 1.5rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        /* Style for Empty History */
        .empty-history {
            padding: 30px;
            text-align: center;
            color: var(--text-dim);
            font-style: italic;
            font-size: 0.9rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes pulseIcon {
            0% {
                transform: scale(1);
                opacity: 0.3;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.6;
            }

            100% {
                transform: scale(1);
                opacity: 0.3;
            }
        }

        @keyframes flashBg {
            from {
                background: #3b82f6;
            }

            to {
                background: #1d4ed8;
            }
        }
    </style>
@endsection

@section('content')
    @php
        $settings = (object) [
            'logo' => 'https://cdn-icons-png.flaticon.com/512/3063/3063822.png',
            'media_type' => 'image',
            'video_url' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4',
            'slideshow_images' => [
                'https://images.unsplash.com/photo-1589829085413-56de8ae18c73?q=80&w=2000&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2000&auto=format&fit=crop',
            ],
            'company_name' => 'RSUD KOTA',
            'running_text' =>
                'PENGUMUMAN: Harap menjaga kebersihan ruang tunggu. Dilarang merokok di area rumah sakit.',
        ];

        $currentQueue = (object) [
            'number' => 'A-012',
            'service' => 'POLI UMUM',
            'counter' => 'LOKET 1',
        ];

        $history = collect([
            (object) ['number' => 'B-005', 'service' => 'FARMASI', 'counter' => 'LOKET 2'],
            (object) ['number' => 'A-011', 'service' => 'POLI UMUM', 'counter' => 'LOKET 1'],
            (object) ['number' => 'C-003', 'service' => 'ADMINISTRASI', 'counter' => 'KASIR'],
            (object) ['number' => 'C-003', 'service' => 'ADMINISTRASI', 'counter' => 'KASIR'],
        ]);
    @endphp

    <div x-data="broadcastSystem" x-init="initApp()" class="broadcast-grid">

        <div class="header-section">
            <div class="brand-wrapper">
                <img src="{{ $settings->logo }}" alt="Logo" class="brand-logo">
                <div class="company-name">{{ $settings->company_name }}</div>
            </div>
            <div class="clock-wrapper">
                <div class="clock-display" x-text="currentTime">--.--</div>
                <div class="date-display" x-text="currentDate">...</div>
            </div>
        </div>

        <div class="left-column">
            <div class="media-card">
                <div class="media-content">
                    @if ($settings->media_type === 'video')
                        <video autoplay loop muted playsinline>
                            <source src="{{ $settings->video_url }}" type="video/mp4">
                        </video>
                    @else
                        <div id="broadcastSlide" class="carousel slide carousel-fade h-100" data-bs-ride="carousel"
                            data-bs-interval="8000">
                            <div class="carousel-inner h-100">
                                @foreach ($settings->slideshow_images as $index => $image)
                                    <div class="carousel-item h-100 {{ $index === 0 ? 'active' : '' }}">
                                        <img src="{{ $image }}" alt="Slide">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                <div class="card-footer-ticker">
                    <div class="ticker-label">
                        <i class="fas fa-info-circle me-2"></i> INFO
                    </div>
                    <div style="flex:1; overflow:hidden; margin-top: 7px;">
                        <marquee class="ticker-text" scrollamount="10">
                            {{ $settings->running_text }}
                        </marquee>
                    </div>
                </div>
            </div>
        </div>

        <div class="right-column">
            <div class="active-ticket-card">
                @if ($currentQueue)
                    <div class="ticket-header">
                        <div class="status-pill">
                            <span class="pulse-dot"></span>
                            <span>SEDANG DIPANGGIL</span>
                        </div>

                        <div class="ticket-label">Nomor Antrian</div>

                        <div class="ticket-number text-wrap"
                            :style="`font-size: ${getFontSize(currentNumber, 'ticket')} !important;`"
                            x-text="currentNumber">
                        </div>
                    </div>

                    <div class="destination-area">
                        <div class="service-name text-wrap" x-text="currentService" style="font-size: 1.2rem;">
                            {{ $currentQueue->service }}
                        </div>

                        <div class="counter-badge">
                            <i class="fas fa-map-marker-alt text-warning"></i>
                            <span class="location-text" x-text="currentCounter">{{ $currentQueue->counter }}</span>
                        </div>
                    </div>
                @else
                    <div class="idle-content">
                        <i class="fas fa-coffee idle-icon"></i>
                        <div class="idle-text">Belum Ada Antrian</div>
                        <div style="font-size: 0.9rem; margin-top: 10px;">Silahkan Menunggu</div>
                    </div>
                @endif
            </div>

            <div class="history-ticket-card">
                <div class="history-header">
                    <i class="fas fa-clock"></i> Riwayat Panggilan
                </div>
                <div class="d-flex flex-column border-top">
                    @forelse ($history as $h)
                        <div class="history-item">
                            <span class="h-num">{{ $h->number }}</span>
                            <div class="h-details">
                                <span class="h-service">{{ $h->service }}</span>
                                <span class="h-counter">{{ $h->counter }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="empty-history">
                            <i class="far fa-folder-open mb-2" style="display:block; font-size: 1.5rem; opacity: 0.5;"></i>
                            Belum ada riwayat panggilan
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div x-show="isCalling" style="display: none;" class="flash-overlay" x-transition:enter="fade-enter-active"
            x-transition:enter-start="fade-enter-start" x-transition:enter-end="fade-enter-end"
            x-transition:leave="fade-leave-active" x-transition:leave-start="fade-leave-start"
            x-transition:leave-end="fade-leave-end">

            <div style="font-size: 2.5rem; text-transform: uppercase; opacity: 0.9; margin-bottom: 20px;">
                Panggilan Nomor
            </div>

            <div style="font-family: 'Oswald', sans-serif; font-size: 14rem; font-weight: 700; line-height: 1;"
                x-text="tempNumber"></div>

            <div style="font-size: 2rem; margin-top: 30px; font-weight: 700; opacity: 0.9;" x-text="tempService"></div>

            <div
                style="font-size: 3rem; font-weight: 700; background: white; color: var(--accent); padding: 15px 60px; border-radius: 100px; margin-top: 20px; box-shadow: 0 20px 50px rgba(0,0,0,0.5);">
                <i class="fas fa-arrow-right-circle me-3"></i>
                <span x-text="tempCounter"></span>
            </div>
        </div>

        <div x-show="showStartOverlay" class="start-overlay">
            <div>
                <i class="fas fa-tv start-icon"></i>
                <h1 class="start-title">Display Antrian</h1>
                <p class="start-subtitle">Klik tombol di bawah untuk memulai layar penuh</p>

                <button @click="enterFullscreen()" class="start-btn">
                    <i class="fas fa-play me-2"></i> MULAI DISPLAY
                </button>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('broadcastSystem', () => ({
                isCalling: false,
                showStartOverlay: true,
                currentNumber: '{{ $currentQueue?->number }}',
                currentService: '{{ $currentQueue?->service }}',
                currentCounter: '{{ $currentQueue?->counter }}',
                tempNumber: '',
                tempService: '',
                tempCounter: '',
                currentTime: '--.--',
                currentDate: '',

                initApp() {
                    this.updateTime();
                    setInterval(() => this.updateTime(), 1000);

                    window.addEventListener('keydown', (e) => {
                        if (e.code === 'Space') {
                            this.call('A-999', 'LOKET 1', 'POLI JANTUNG & PEMBULUH DARAH');
                        }
                    });
                },

                enterFullscreen() {
                    const elem = document.documentElement;

                    if (elem.requestFullscreen) {
                        elem.requestFullscreen();
                    } else if (elem.webkitRequestFullscreen) {
                        elem.webkitRequestFullscreen();
                    } else if (elem.msRequestFullscreen) {
                        elem.msRequestFullscreen();
                    }

                    this.showStartOverlay = false;

                    // const audio = new Audio('/empty.mp3'); 
                    // audio.play().catch(e => {});
                },

                getFontSize(text, type) {
                    const length = text ? text.length : 0;

                    if (type === 'ticket') {
                        if (length <= 5) return '8rem';
                        if (length <= 7) return '6rem';
                        return '4.5rem';
                    }

                    if (type === 'service') {
                        if (length <= 15) return '1.2rem';
                        if (length <= 25) return '1.2rem';
                        return '1rem';
                    }

                    return '1rem';
                },

                updateTime() {
                    const now = new Date();

                    this.currentTime = now.toLocaleTimeString('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false
                    });

                    this.currentDate = now.toLocaleDateString('id-ID', {
                        weekday: 'long',
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });
                },

                call(number, counter, service) {
                    if (this.isCalling) return;

                    this.tempNumber = number;
                    this.tempCounter = counter;
                    this.tempService = service;
                    this.isCalling = true;

                    setTimeout(() => {
                        this.isCalling = false;
                        this.currentNumber = number;
                        this.currentCounter = counter;
                        this.currentService = service;
                    }, 5000);
                }
            }));
        });
    </script>
@endsection
