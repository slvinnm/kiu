@extends('frontend.layouts.main')

@section('title', 'Antrian Display')

@section('css')
    <style>
        /* 1. VARIABLES & BASE STYLES */
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

        /* 2. GLOBAL LAYOUT (GRID & COLUMNS) */
        .broadcast-grid {
            display: grid;
            grid-template-columns: 1fr 550px;
            grid-template-rows: 90px 1fr;
            height: 100vh;
        }

        .left-column {
            grid-row: 2 / 3;
            grid-column: 1 / 2;
            padding: 20px;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .right-column {
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 15px;
            height: calc(100vh - 90px);
            overflow: hidden;
        }

        /* 3. HEADER SECTION & BRANDING */
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

        /* --- Clock & Date --- */
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

        /* 4. MEDIA & TICKER COMPONENTS (LEFT COLUMN) */
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

        /* --- Footer Ticker --- */
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

        /* 5. TICKET & HISTORY COMPONENTS (RIGHT COLUMN) */
        .active-ticket-card {
            background: var(--accent-gradient);
            border-radius: 20px;
            min-height: 320px;
            flex: 0 0 auto;
            display: flex;
            flex-direction: column;
            position: relative;
            box-shadow: 0 20px 40px -10px rgba(59, 130, 246, 0.6);

            -webkit-mask-image: radial-gradient(circle at 0 70%, transparent 15px, black 16px),
                radial-gradient(circle at 100% 70%, transparent 15px, black 16px);
            mask-image: radial-gradient(circle at 0 70%, transparent 15px, black 16px),
                radial-gradient(circle at 100% 70%, transparent 15px, black 16px);
            -webkit-mask-composite: source-in;
            mask-composite: intersect;
        }

        .ticket-header {
            height: 70%;
            padding: 20px;
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
            font-size: clamp(3rem, 8vh, 6rem);
            margin-top: 10px;
            text-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .destination-area {
            height: 30%;
            background: rgba(0, 0, 0, 0.15);
            padding: 10px 20px;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 5px;
            position: relative;
        }

        .destination-area::before {
            content: '';
            position: absolute;
            top: 0;
            left: 20px;
            right: 20px;
            border-top: 2px dashed rgba(255, 255, 255, 0.3);
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
            font-size: clamp(1rem, 2.5vh, 1.8rem);
            font-weight: 800;
            padding: 8px 20px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .counter-text {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* --- Idle/Empty State --- */
        .empty-ticket-content {
            display: flex;
            flex-direction: column;
            height: 100%;
            width: 100%;
        }

        .empty-ticket-main {
            height: 70%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .empty-ticket-icon {
            font-size: 4.5rem;
            color: rgba(255, 255, 255, 0.25);
            animation: pulseIcon 3s infinite ease-in-out;
        }

        .empty-ticket-footer {
            height: 30%;
            background: rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .empty-ticket-footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 20px;
            right: 20px;
            border-top: 2px dashed rgba(255, 255, 255, 0.15);
        }

        /* --- History List & Sidebar Elements --- */
        .history-ticket-card {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 16px;
            padding: 15px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            min-height: 0;
            flex: 1;
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
            padding: 10px 12px;
            margin-bottom: 8px;
            background: rgba(255, 255, 255, 0.02);
            border-radius: 8px;
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

        .empty-history {
            border-top: none;
            opacity: 0.5;
            padding: 20px 0;
            text-align: center;
            color: var(--text-dim);
            font-style: italic;
            font-size: 0.9rem;
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

        /* --- Start/Intro Overlay --- */
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

        .pulse-dot {
            width: 10px;
            height: 10px;
            background: #22c55e;
            border-radius: 50%;
            animation: pulse 1.5s infinite;
        }

        .overflow-auto::-webkit-scrollbar {
            width: 4px;
        }

        .overflow-auto::-webkit-scrollbar-track {
            background: transparent;
        }

        .overflow-auto::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        /* 7. KEYFRAMES & TRANSITIONS */
        @keyframes pulse {

            0%,

            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.2);
                opacity: 0.7;
            }
        }

        @keyframes pulseIcon {

            0%,

            100% {
                transform: scale(1);
                opacity: 0.3;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.6;
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

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
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
    </style>
@endsection

@section('content')
    <div x-data="displayApp" x-init="initApp()" class="broadcast-grid">

        <div class="header-section">
            <div class="brand-wrapper">
                <img :src="setting.logo" alt="Logo" class="brand-logo" x-show="setting.logo" style="display: none;">
                <div class="company-name" x-text="setting.name">Loading...</div>
            </div>
            <div class="clock-wrapper">
                <div class="clock-display" x-text="currentTime">--.--</div>
                <div class="date-display" x-text="currentDate">...</div>
            </div>
        </div>

        <div class="left-column">
            <div class="media-card">
                <div class="media-content">
                    <template x-if="setting.media_type === 'video'">
                        <video autoplay loop muted playsinline :src="setting.video"></video>
                    </template>

                    <template x-if="setting.media_type === 'image'">
                        <div id="broadcastSlide" class="carousel slide carousel-fade h-100" data-bs-ride="carousel"
                            data-bs-interval="8000">
                            <div class="carousel-inner h-100">
                                <template x-for="(image, index) in setting.slideshow" :key="index">
                                    <div class="carousel-item h-100" :class="{ 'active': index === 0 }">
                                        <img :src="image" alt="Slide" class="d-block w-100 h-100"
                                            style="object-fit: cover;">
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
                <div class="card-footer-ticker">
                    <div class="ticker-label"><i class="fas fa-info-circle me-2"></i> INFO</div>
                    <div style="flex:1; overflow:hidden; margin-top: 7px;">
                        <marquee class="ticker-text" scrollamount="10" x-text="setting.running_text">
                            Memuat Informasi...
                        </marquee>
                    </div>
                </div>
            </div>
        </div>

        <div class="right-column">
            <div class="active-ticket-card">
                <template x-if="current">
                    <div class="w-100 h-100 d-flex flex-column">
                        <div class="ticket-header">
                            <div class="status-pill">
                                <span class="pulse-dot"></span>
                                <span>SEDANG DIPANGGIL</span>
                            </div>
                            <div class="ticket-label">Nomor Antrian</div>
                            <div class="ticket-number" x-text="current.ticket?.ticket_number"></div>
                        </div>
                        <div class="destination-area">
                            <div class="service-name text-wrap text-center" x-text="current.service?.name"></div>
                            <div class="counter-badge">
                                <i class="fas fa-chevron-circle-right text-warning"></i>
                                <span class="counter-text" x-text="current.counter?.name"></span>
                            </div>
                        </div>
                    </div>
                </template>
                <template x-if="!current">
                    <div class="empty-ticket-content" x-transition:enter="fadeIn">
                        <div class="empty-ticket-main">
                            <i class="fas fa-mug-hot empty-ticket-icon"></i>
                            <div class="empty-ticket-text"
                                style="font-size: 1.4rem; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; color: rgba(255,255,255,0.4);">
                                Belum Ada Antrian
                            </div>
                        </div>
                        <div class="empty-ticket-footer">
                            <div
                                style="font-size: 0.9rem; color: rgba(255,255,255,0.3); text-transform: uppercase; letter-spacing: 1px;">
                                Silahkan Menunggu
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            <div class="history-ticket-card flex-grow-1 d-flex flex-column overflow-hidden">
                <div class="history-header">
                    <i class="fas fa-users-cog text-success"></i> Sedang Dilayani
                </div>
                <div class="flex-grow-1 overflow-auto pe-1">
                    <template x-for="active in activeCounters" :key="'active-' + active.id">
                        <div class="history-item border-start border-4 border-success">
                            <span class="h-num text-success fw-bold" x-text="active.ticket?.ticket_number"></span>
                            <div class="h-details">
                                <span class="h-service text-white" x-text="active.service?.name"></span>
                                <span class="h-counter" x-text="active.counter?.name"></span>
                            </div>
                        </div>
                    </template>
                    <template x-if="activeCounters.length === 0">
                        <div class="empty-history">Tidak ada loket aktif</div>
                    </template>
                </div>
            </div>

            <div class="history-ticket-card flex-grow-1 d-flex flex-column overflow-hidden">
                <div class="history-header">
                    <i class="fas fa-history text-secondary"></i> Riwayat Selesai
                </div>
                <div class="flex-grow-1 overflow-auto pe-1">
                    <template x-for="h in history" :key="'hist-' + h.id">
                        <div class="history-item opacity-75">
                            <span class="h-num text-dim" x-text="h.ticket?.ticket_number"></span>
                            <div class="h-details">
                                <span class="h-service" x-text="h.service?.name"></span>
                                <span class="h-counter" x-text="h.counter?.name"></span>
                            </div>
                        </div>
                    </template>
                    <template x-if="history.length === 0">
                        <div class="empty-history">Belum ada riwayat</div>
                    </template>
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
                x-text="currentCall.ticket?.ticket_number"></div>

            <div style="font-size: 2rem; margin-top: 30px; font-weight: 700; opacity: 0.9;"
                x-text="currentCall.service?.name">
            </div>

            <div
                style="font-size: 3rem; font-weight: 700; background: white; color: var(--accent); padding: 15px 60px; border-radius: 100px; margin-top: 20px; box-shadow: 0 20px 50px rgba(0,0,0,0.5);">
                <i class="fas fa-chevron-circle-right text-warning me-3"></i>
                <span x-text="currentCall.counter?.name"></span>
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
        function displayApp() {
            return {
                isCalling: false,
                showStartOverlay: true,
                isLoading: true,

                setting: {
                    logo: '',
                    name: '',
                    media_type: 'image',
                    video: '',
                    slideshow: [],
                    running_text: 'Memuat Data...'
                },

                activeCounters: [],
                history: [],
                current: null,

                // Dummy structure for animation initial state
                currentCall: {
                    ticket: {
                        ticket_number: '---'
                    },
                    counter: {
                        name: '---'
                    },
                    service: {
                        name: '---'
                    }
                },

                currentTime: '--.--',
                currentDate: '',

                async initApp() {
                    this.updateTime();
                    setInterval(() => this.updateTime(), 1000);
                    await this.fetchDisplay();

                    // Keydown Simulator
                    window.addEventListener('keydown', (e) => {
                        if (e.code === 'Space') {
                            this.call({
                                ticket: {
                                    ticket_number: 'A-123'
                                },
                                counter: {
                                    name: 'LOKET TES'
                                },
                                service: {
                                    name: 'POLI TES'
                                }
                            });
                        }
                    });
                },

                async fetchDisplay() {
                    try {
                        const res = await fetch("{{ route('fetch.display.data') }}");
                        const result = await res.json();

                        this.setting = result.setting;
                        this.activeCounters = result.active_counters || [];
                        this.history = result.history || [];

                        if (!this.isCalling && result.current) {
                            this.current = result.current;
                        }
                    } catch (e) {
                        console.error('Display fetch failed', e);
                    } finally {
                        this.isLoading = false;
                    }
                },

                call(incomingData) {
                    if (this.isCalling) return;

                    this.fetchDisplay().then(() => {
                        console.log("Background data updated");
                    });

                    this.currentCall = incomingData;
                    this.isCalling = true;

                    setTimeout(() => {
                        this.isCalling = false;
                        this.current = incomingData;
                    }, 5000);
                },

                enterFullscreen() {
                    const elem = document.documentElement;
                    if (elem.requestFullscreen) elem.requestFullscreen();
                    else if (elem.webkitRequestFullscreen) elem.webkitRequestFullscreen();
                    else if (elem.msRequestFullscreen) elem.msRequestFullscreen();
                    this.showStartOverlay = false;
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
                }
            }
        }
    </script>
@endsection
