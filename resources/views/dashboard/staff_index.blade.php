@extends('dashboard.layouts.main')

@section('title', 'Dashboard')

@section('page-heading')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Dashboard</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .fw-black {
            font-weight: 900;
        }

        @keyframes pulse-blue {
            0% {
                box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.7);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(13, 110, 253, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(13, 110, 253, 0);
            }
        }

        .btn-pulse {
            animation: pulse-blue 2s infinite;
        }

        .hover-lift {
            transition: all 0.2s ease-in-out;
        }

        .hover-lift:hover {
            transform: translateY(-3px);
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
        }
    </style>
@endsection

@section('content')
    <section>
        @php
            $counter = Auth::user()->counter;
            $currentStatus = $counter->status ?? 'closed';

            $statusColor = match ($currentStatus) {
                'open' => 'success',
                'break' => 'warning',
                'closed' => 'danger',
                default => 'secondary',
            };
            $statusLabel = \App\Models\Counter::STATUS[$currentStatus] ?? 'Offline';
        @endphp

        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-3">
                <div class="row align-items-center g-3">
                    <div class="col-12 col-md-4">
                        <div class="d-flex align-items-center">
                            <div class="position-relative me-3">
                                <img src="{{ asset('theme/dashboard/assets/compiled/jpg/1.jpg') }}"
                                    class="rounded-circle border border-2 border-secondary-subtle shadow-sm"
                                    style="width: 60px; height: 60px; object-fit: cover;"> <span
                                    class="position-absolute bottom-0 start-100 translate-middle p-1 bg-success border border-2 border-body rounded-circle"
                                    data-bs-toggle="tooltip" title="Status: Online"></span>
                            </div>

                            <div>
                                <div class="mb-2">
                                    <h6 class="fw-bold mb-0 text-body-emphasis">{{ Auth::user()->name }}</h6>
                                    <small class="text-body-secondary" style="font-size: 0.75rem;">
                                        {{ '@' . Auth::user()->username }} &bull; Staff
                                    </small>
                                </div>

                                <div class="d-flex gap-2 flex-wrap">

                                    <div class="badge bg-warning-subtle text-warning-emphasis px-2 py-1 hover-lift cursor-pointer icon-fix"
                                        data-bs-toggle="tooltip" title="Total Menunggu">
                                        <i class="bi bi-clock-history me-1"></i>
                                        <span>{{ $stats->waiting ?? 0 }}</span>
                                    </div>

                                    <div class="badge bg-success-subtle text-success-emphasis px-2 py-1 hover-lift cursor-pointer icon-fix"
                                        data-bs-toggle="tooltip" title="Total Selesai">
                                        <i class="bi bi-check-circle-fill me-1"></i>
                                        <span>{{ $stats->completed ?? 0 }}</span>
                                    </div>

                                    <div class="badge bg-danger-subtle text-danger-emphasis px-2 py-1 hover-lift cursor-pointer icon-fix"
                                        data-bs-toggle="tooltip" title="Total Dilewati">
                                        <i class="bi bi-dash-circle-fill me-1"></i>
                                        <span>{{ $stats->skipped ?? 0 }}</span>
                                    </div>

                                    <div class="badge bg-primary-subtle text-primary-emphasis px-2 py-1 hover-lift cursor-pointer icon-fix"
                                        data-bs-toggle="tooltip" title="Rata-rata Waktu Layanan">
                                        <i class="bi bi-stopwatch-fill me-1"></i>
                                        <span>{{ $stats->avg_time ?? '0m' }}</span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-4 text-md-center">
                        <small class="text-uppercase text-body-secondary fw-bold"
                            style="font-size: 0.65rem; letter-spacing: 1px;">
                            Loket Saat Ini
                        </small>

                        <h4 class="fw-bold text-body-emphasis mb-2 mt-1">
                            {{ $counter->name ?? 'No Counter' }}
                        </h4>

                        <div class="d-flex justify-content-center">
                            <div
                                class="badge bg-body-tertiary text-body border border-secondary-subtle rounded-pill px-3 py-2 d-flex align-items-center gap-2 fw-normal">
                                <i class="bi bi-calendar4-week text-primary"></i>
                                <span id="live-date" class="small">...</span>
                                <div class="vr mx-1"></div> <span id="live-time"
                                    class="fw-bold font-monospace text-primary">...</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-4 ">
                        <div class="dropdown">
                            <button
                                class="btn border rounded-pill w-100 py-2 d-flex align-items-center justify-content-between px-3"
                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <span class="rounded-circle me-2 shadow-sm bg-{{ $statusColor }}"
                                        style="width: 10px; height: 10px;">
                                    </span>
                                    <span class="fw-bold text-body">{{ $statusLabel }}</span>
                                </div>
                                <i class="bi bi-chevron-down small mb-2"></i>
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 mt-2 p-2 w-100">
                                <li class="dropdown-header text-uppercase small fw-bold text-muted mb-1">
                                    Set Status Loket
                                </li>

                                @foreach (\App\Models\Counter::STATUS as $key => $label)
                                    <li>
                                        <form action="#" method="POST">
                                            <button
                                                class="dropdown-item rounded-3 py-2 d-flex align-items-center justify-content-between mb-1 {{ $currentStatus == $key ? 'active' : '' }}">
                                                <span>{{ $label }}</span>
                                                @if ($currentStatus == $key)
                                                    <i class="bi bi-check-circle-fill mb-2"></i>
                                                @endif
                                            </button>
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mb-4">
                @if (!$currentQueue)
                    <div class="card border-2 border-dashed shadow-none mb-4 bg-body-tertiary text-center"
                        style="border-style: dashed !important; border-color: var(--bs-primary) !important;">
                        <div class="card-body py-5">
                            <div class="mb-4">
                                <i class="bi bi-megaphone text-primary" style="font-size: 3rem;"></i>
                            </div>

                            <h4 class="fw-bold text-body-emphasis">Loket Tersedia</h4>

                            @if ($nextQueue)
                                <p class="text-muted mb-4">
                                    Antrian berikutnya tersedia. <br>
                                    Siap memanggil tiket <strong>{{ $nextQueue->ticket_number }}</strong> ?
                                </p>
                                <button class="btn btn-primary btn-lg rounded-pill px-5 py-3 shadow-sm btn-pulse">
                                    <i class="bi bi-broadcast me-2"></i> Panggil {{ $nextQueue->ticket_number }}
                                </button>
                            @else
                                <p class="text-muted mb-4">Belum ada antrian baru. Menunggu pengunjung...</p>
                                <button class="btn btn-secondary btn-lg rounded-pill px-5 py-3 shadow-sm" disabled>
                                    <i class="bi bi-hourglass-split me-2"></i> Menunggu Antrian
                                </button>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden h-100 ">
                        <div
                            class="card-header border-0 pt-4 px-4 d-flex justify-content-between align-items-center bg-transparent">
                            <div>
                                <span
                                    class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-3 py-2">
                                    <span class="spinner-grow spinner-grow-sm me-1" role="status"
                                        aria-hidden="true"></span>
                                    Sedang Melayani
                                </span>
                            </div>
                            <div class="text-muted bg-body-secondary rounded-pill px-3 py-1">
                                <i class="bi bi-stopwatch me-2"></i>
                                <span class="fw-bold font-monospace text-body-emphasis" id="timer">00:00</span>
                            </div>
                        </div>

                        <div class="card-body text-center px-4 pb-4 pt-2 d-flex flex-column justify-content-center">

                            <div class="mb-2">
                                <small class="text-uppercase text-muted fw-bold letter-spacing-2 mb-2 d-block">Nomor
                                    Antrian</small>
                                <div class="d-inline-block position-relative">
                                    <h1 class="display-1 fw-black text-heading mb-0"
                                        style="font-size: 6rem; font-weight: 800; letter-spacing: -3px; line-height: 1;">
                                        {{ $currentQueue->ticket_number ?? '--' }}
                                    </h1>
                                </div>
                            </div>

                            <div class="my-4">
                                <div
                                    class="bg-body-tertiary border border-opacity-10 rounded-3 p-3 text-start d-flex justify-content-between align-items-center position-relative overflow-hidden">
                                    <div class="position-absolute start-0 top-0 bottom-0 bg-primary" style="width: 4px;">
                                    </div>

                                    <div class="ps-2">
                                        <small class="text-uppercase text-muted fw-bold"
                                            style="font-size: 0.65rem; letter-spacing: 1px;">
                                            <i class="bi bi-arrow-right-circle me-1"></i> Persiapan Berikutnya
                                        </small>
                                        <div class="d-flex align-items-center mt-1">
                                            @if ($nextQueue)
                                                <h4 class="mb-0 fw-bold text-body-emphasis me-2">
                                                    {{ $nextQueue->ticket_number }}</h4>
                                                <span
                                                    class="badge bg-secondary-subtle text-secondary-emphasis border shadow-sm"
                                                    style="font-size: 0.7rem;">
                                                    Menunggu
                                                </span>
                                            @else
                                                <span class="text-muted fst-italic small">Tidak ada antrian</span>
                                            @endif
                                        </div>
                                    </div>

                                    @if ($nextQueue)
                                        <div class="text-end">
                                            <small class="text-muted d-block" style="font-size: 0.7rem;">Total
                                                Menunggu</small>
                                            <span class="fw-bold text-body small">{{ count($waitingList) ?? 0 }}
                                                Orang</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-6">
                                    <button class="btn btn-warning w-100 btn-lg text-white shadow-sm rounded-3">
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            <i class="bi bi-arrow-counterclockwise fs-4 mb-3"></i>
                                            <span class="fw-bold small">Panggil Ulang</span>
                                        </div>
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button class="btn btn-success w-100 btn-lg shadow rounded-3">
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            <i class="bi bi-check-lg fs-4 mb-3"></i>
                                            <span class="fw-bold small">Selesaikan</span>
                                        </div>
                                    </button>
                                </div>
                            </div>

                            <div class="position-relative text-center w-100 mb-4">
                                <hr class="text-muted opacity-25">
                                <span
                                    class="position-absolute top-50 start-50 translate-middle px-2 bg-body text-muted small text-uppercase"
                                    style="font-size: 0.65rem;">Opsi Lainnya
                                </span>
                            </div>

                            <div class="d-flex justify-content-center gap-3">
                                <button class="btn btn-outline-danger btn-sm rounded-pill px-4 hover-lift">
                                    <i class="bi bi-slash-circle me-1"></i> Lewati (Skip)
                                </button>
                                <button class="btn btn-outline-secondary btn-sm rounded-pill px-4 hover-lift">
                                    <i class="bi bi-arrow-left-right me-1"></i> Transfer
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills nav-fill" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active fw-bold " id="pills-waiting-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-waiting" type="button" role="tab">
                                    <i class="bi bi-people me-1"></i> Menunggu
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-bold " id="pills-history-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-history" type="button" role="tab">
                                    <i class="bi bi-clock-history me-1"></i> Riwayat
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body p-0 mt-2" style="max-height: 420px; height: 420px; overflow-y: auto;">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-waiting" role="tabpanel">
                                <ul class="list-group list-group-flush">
                                    @forelse ($waitingList as $q)
                                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-body-secondary rounded-circle d-flex align-items-center justify-content-center me-3 text-body fw-bold"
                                                    style="width: 40px; height: 40px;">
                                                    {{ $loop->iteration }}
                                                </div>
                                                <div>
                                                    <h5 class="mb-0 fw-bold">{{ $q->ticket_number }}</h5>
                                                    <small class="text-muted">Walk-in</small>
                                                </div>
                                            </div>
                                            <button class="btn btn-sm btn-outline-primary rounded-circle"
                                                data-bs-toggle="tooltip" title="Panggil Langsung">
                                                <i class="bi bi-play-fill"></i>
                                            </button>
                                        </li>
                                    @empty
                                        <div class="text-center py-5">
                                            <p class="text-muted small">Tidak ada antrian menunggu</p>
                                        </div>
                                    @endforelse
                                </ul>
                            </div>

                            <div class="tab-pane fade" id="pills-history" role="tabpanel">
                                <ul class="list-group list-group-flush">
                                    @forelse ($historyList as $h)
                                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                            <div>
                                                <span class="fw-bold text-muted">{{ $h->ticket_number }}</span>
                                            </div>
                                            <div>
                                                @if ($h->status == 'completed')
                                                    <span
                                                        class="badge bg-success-subtle text-success-emphasis rounded-pill">Selesai</span>
                                                @else
                                                    <span
                                                        class="badge bg-danger-subtle text-danger-emphasis rounded-pill">Skipped</span>
                                                @endif
                                            </div>
                                        </li>
                                    @empty
                                        <div class="text-center py-5">
                                            <p class="text-muted small">Tidak ada riwayat antrian</p>
                                        </div>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const queueId = "{{ $currentQueue->id ?? 'no-queue' }}";
            const isServing = "{{ isset($currentQueue) && $currentQueue->status == 'serving' ? 'yes' : 'no' }}";
            const serverStartTime = parseInt("{{ $serverTimeMs ?? 0 }}");
            const storageKey = `queue_start_${queueId}`;
            const timerEl = document.getElementById('timer');
            let intervalId;

            function formatTime(totalSeconds) {
                totalSeconds = Math.max(0, Math.floor(totalSeconds));

                const h = Math.floor(totalSeconds / 3600).toString().padStart(2, '0');
                const m = Math.floor((totalSeconds % 3600) / 60).toString().padStart(2, '0');
                const s = (totalSeconds % 60).toString().padStart(2, '0');

                return `${h}:${m}:${s}`;
            }

            function startTimer() {
                let startTimestamp = localStorage.getItem(storageKey);

                if (serverStartTime > 0) {
                    if (!startTimestamp || Math.abs(startTimestamp - serverStartTime) > 5000) {
                        startTimestamp = serverStartTime;
                        localStorage.setItem(storageKey, startTimestamp);
                    }
                } else if (!startTimestamp) {
                    startTimestamp = Date.now();
                    localStorage.setItem(storageKey, startTimestamp);
                }

                if (intervalId) clearInterval(intervalId);

                intervalId = setInterval(() => {
                    const now = Date.now();
                    const diffInSeconds = (now - startTimestamp) / 1000;

                    if (timerEl) {
                        timerEl.innerText = formatTime(diffInSeconds);
                    }
                }, 1000);
            }

            if (isServing === 'yes') {
                startTimer();
            } else {
                if (queueId !== 'no-queue') localStorage.removeItem(storageKey);
                if (timerEl) timerEl.innerText = "00:00:00";
            }

            function updateClock() {
                const now = new Date();

                const optionsDate = {
                    weekday: 'long',
                    day: 'numeric',
                    month: 'short'
                };
                const dateString = now.toLocaleDateString('id-ID', optionsDate);

                const h = now.getHours().toString().padStart(2, '0');
                const m = now.getMinutes().toString().padStart(2, '0');
                const s = now.getSeconds().toString().padStart(2, '0');

                const timeString = `${h}:${m}:${s}`;

                const timeEl = document.getElementById('live-time');
                const dateEl = document.getElementById('live-date');

                if (timeEl) timeEl.innerText = timeString;
                if (dateEl) dateEl.innerText = dateString;
            }

            updateClock();
            setInterval(updateClock, 1000);
        });
    </script>
@endsection
