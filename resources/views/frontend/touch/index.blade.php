@extends('frontend.layouts.main')

@section('title', 'Ambil Antrian')

@section('content')
    <style>
        /* --- 1. SETUP BACKGROUND --- */
        .kiosk-wrapper {
            background-image: url('https://images.unsplash.com/photo-1557683316-973673baf926?q=80&w=2029&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            height: 100vh;
            width: 100vw;
            overflow: hidden;
            /* Hide main body scroll */
            position: relative;
        }

        .kiosk-overlay {
            background: rgba(15, 23, 42, 0.75);
            /* Dark Blue overlay for modern look */
            height: 100%;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding-top: 2rem;
            padding-bottom: 2rem;
        }

        /* --- 2. THE SLIDER CONTAINER (CORE LOGIC) --- */
        .slider-viewport {
            width: 100%;
            overflow-x: auto;
            /* Enable Horizontal Scroll */
            padding: 0 5vw;
            /* Padding kiri-kanan */
            /* Sembunyikan Scrollbar agar bersih */
            scrollbar-width: none;
            /* Firefox */
            -ms-overflow-style: none;
            /* IE */
        }

        .slider-viewport::-webkit-scrollbar {
            display: none;
            /* Chrome/Safari */
        }

        .cards-grid {
            display: grid;
            /* KUNCI: 2 Baris, sisanya ke samping */
            grid-template-rows: repeat(2, 1fr);
            grid-auto-flow: column;

            /* Lebar Kartu diperbesar */
            grid-auto-columns: 350px;

            gap: 25px;
            /* Jarak antar kartu */
            height: 60vh;
            /* Tinggi area slider */
            align-content: center;

            /* Snap Effect agar berhenti pas di kartu */
            scroll-snap-type: x mandatory;
        }

        /* --- 3. NEW CARD STYLE: "Floating Tile" --- */
        .service-card-btn {
            border: none;
            background: none;
            padding: 0;
            width: 100%;
            height: 100%;
            text-align: left;
        }

        .service-tile {
            background: white;
            height: 100%;
            width: 100%;
            border-radius: 24px;
            padding: 1.5rem 2rem;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            scroll-snap-align: center;
            /* Snap target */
            border-left: 8px solid transparent;
            /* Aksen warna */
            overflow: hidden;
        }

        /* Animasi saat ditekan */
        .service-card-btn:active .service-tile {
            transform: scale(0.95);
            background: #f1f5f9;
        }

        /* Isi Kartu */
        .tile-content h3 {
            font-size: 1.75rem;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 0.5rem;
            line-height: 1.2;
        }

        .tile-content p {
            color: #64748b;
            font-size: 1rem;
            font-weight: 500;
            margin: 0;
        }

        /* Icon Besar di Kanan */
        .tile-icon {
            font-size: 3.5rem;
            opacity: 0.1;
            /* Icon watermark style */
            position: absolute;
            right: -10px;
            bottom: -10px;
            transform: rotate(-15deg);
            transition: 0.3s;
        }

        /* State Active/Hover untuk Card */
        .service-tile:hover .tile-icon {
            opacity: 0.2;
            transform: rotate(0deg) scale(1.2);
        }

        /* Warna Aksen Dinamis */
        .accent-blue {
            border-left-color: #3b82f6;
        }

        .accent-blue .tile-icon {
            color: #3b82f6;
        }

        .accent-teal {
            border-left-color: #14b8a6;
        }

        .accent-teal .tile-icon {
            color: #14b8a6;
        }

        .accent-purple {
            border-left-color: #a855f7;
        }

        .accent-purple .tile-icon {
            color: #a855f7;
        }

        .accent-rose {
            border-left-color: #f43f5e;
        }

        .accent-rose .tile-icon {
            color: #f43f5e;
        }

        /* Navigation Arrows (Opsional jika antrian banyak) */
        .scroll-btn {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            backdrop-filter: blur(5px);
            transition: 0.2s;
        }

        .scroll-btn:active {
            background: rgba(255, 255, 255, 0.4);
        }
    </style>

    <div class="kiosk-wrapper">
        <div class="kiosk-overlay">

            <div class="container-fluid px-5">
                <div
                    class="d-flex justify-content-between align-items-end border-bottom border-light border-opacity-25 pb-4">
                    <div class="text-white">
                        <h1 class="fw-black display-5 mb-0">Layanan Antrian</h1>
                        <p class="lead opacity-75 mb-0">Sentuh kartu layanan untuk mengambil tiket</p>
                    </div>
                    <div class="text-end text-white">
                        <div class="fs-1 fw-bold font-monospace" id="clock">12:45</div>
                        <small class="text-uppercase letter-spacing-2 opacity-75" id="date">SENIN, 20 OKTOBER
                            2025</small>
                    </div>
                </div>
            </div>

            <div class="slider-viewport" id="scrollContainer">
                <div class="cards-grid">
                    @forelse($services as $index => $service)
                        @php
                            // Rotasi warna
                            $colors = ['accent-blue', 'accent-teal', 'accent-purple', 'accent-rose'];
                            $colorClass = $colors[$index % 4];

                            // Icon mapping
                            $icon = 'fa-circle-notch';
                            if (stripos($service->name, 'gigi') !== false) {
                                $icon = 'fa-tooth';
                            }
                            if (stripos($service->name, 'umum') !== false) {
                                $icon = 'fa-stethoscope';
                            }
                            if (stripos($service->name, 'apotek') !== false) {
                                $icon = 'fa-prescription-bottle-alt';
                            }
                            if (stripos($service->name, 'anak') !== false) {
                                $icon = 'fa-baby-carriage';
                            }
                            if (stripos($service->name, 'kasir') !== false) {
                                $icon = 'fa-cash-register';
                            }
                        @endphp

                        <form action="#" method="POST" class="h-100">
                            @csrf
                            <input type="hidden" name="service_id" value="{{ $service->id }}">

                            <button type="submit" class="service-card-btn">
                                <div class="service-tile {{ $colorClass }}">
                                    <div class="tile-content">
                                        <span
                                            class="badge bg-light text-dark mb-2 rounded-1 border fw-bold">{{ $service->code }}</span>
                                        <h3>{{ $service->name }}</h3>
                                        @if ($service->avg_wait_time)
                                            <p><i class="fas fa-clock me-1"></i> ± {{ $service->avg_wait_time }} Menit</p>
                                        @endif
                                    </div>
                                    <i class="fas {{ $icon }} tile-icon"></i>
                                </div>
                            </button>
                        </form>
                    @empty
                        <div class="text-white p-5">Tidak ada layanan aktif</div>
                    @endforelse
                </div>
            </div>

            <div class="container-fluid px-5">
                <div class="d-flex justify-content-center align-items-center gap-4">
                    <button class="scroll-btn" onclick="scrollGrid('left')">
                        <i class="fas fa-chevron-left fa-lg"></i>
                    </button>

                    <span class="text-white opacity-50 small text-uppercase letter-spacing-2">
                        <i class="fas fa-hand-pointer me-2"></i> Geser layar untuk layanan lainnya
                    </span>

                    <button class="scroll-btn" onclick="scrollGrid('right')">
                        <i class="fas fa-chevron-right fa-lg"></i>
                    </button>
                </div>
            </div>

        </div>
    </div>

    <script>
        // 1. Clock Logic
        function updateTime() {
            const now = new Date();
            document.getElementById('clock').innerText = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit'
            });
            document.getElementById('date').innerText = now.toLocaleDateString('id-ID', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
        }
        setInterval(updateTime, 1000);
        updateTime();

        // 2. Scroll Logic (Untuk tombol panah)
        const container = document.getElementById('scrollContainer');

        function scrollGrid(direction) {
            const scrollAmount = 400; // Lebar kartu + gap
            if (direction === 'left') {
                container.scrollBy({
                    left: -scrollAmount,
                    behavior: 'smooth'
                });
            } else {
                container.scrollBy({
                    left: scrollAmount,
                    behavior: 'smooth'
                });
            }
        }
    </script>

@endsection
