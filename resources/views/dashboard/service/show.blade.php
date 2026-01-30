@extends('dashboard.layouts.main')

@section('title', 'Detail Layanan')

@section('content')
    <section class="section">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('services.index') }}" class="btn rounded-pill btn-warning">
                <i class="bi bi-chevron-left me-1"></i> Kembali
            </a>
            <a href="{{ route('services.edit', $service->id) }}" class="btn rounded-pill btn-primary shadow-sm px-4">
                <i class="bi bi-pencil-square me-1"></i> Edit Layanan
            </a>
        </div>

        <div class="row">
            <div class="col-12 col-lg-8 mx-auto">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    @if ($service->icon)
                                        <div class="rounded-3 shadow-sm border overflow-hidden"
                                            style="width: 60px; height: 60px;">
                                            <img src="{{ asset('storage/' . $service->icon) }}"
                                                alt="Icon {{ $service->name }}" class="w-100 h-100"
                                                style="object-fit: cover;">
                                        </div>
                                    @else
                                        <i class="bi bi-stack fs-3"></i>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="text-dark mb-0">{{ $service->name }}</h4>
                                </div>
                            </div>
                            <div>
                                @if ($service->is_active)
                                    <span
                                        class="badge bg-light-success text-success border border-success px-3 py-2 rounded-pill">
                                        <i class="bi bi-circle-fill me-1 small"></i> Aktif
                                    </span>
                                @else
                                    <span
                                        class="badge bg-light-secondary text-secondary border border-secondary px-3 py-2 rounded-pill">
                                        <i class="bi bi-circle-fill me-1 small"></i> Non-Aktif
                                    </span>
                                @endif
                            </div>
                        </div>

                        <hr class="opacity-25">

                        <div class="row g-4 mb-2">
                            <div class="col-md-4">
                                <label class="text-muted small d-block">Kode Layanan</label>
                                <span class="fw-bold text-primary font-monospace fs-5">{{ $service->code }}</span>
                            </div>
                            <div class="col-md-4">
                                <label class="text-muted small d-block">Jam Operasional</label>
                                <span class="fw-bold text-dark">
                                    {{ $service->opening_time ?? '--:--' }} - {{ $service->closing_time ?? '--:--' }}
                                </span>
                            </div>
                            <div class="col-md-4">
                                <label class="text-muted small d-block">Kuota Harian</label>
                                <span class="fw-bold text-dark">{{ $service->max_queue_per_day ?? '∞' }} Antrean</span>
                            </div>
                        </div>

                        <hr class="opacity-25">

                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <h6 class="text-uppercase text-muted small fw-bold mb-3">Operator</h6>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-lg me-3">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($service->operator->name) }}&background=f0f5ff&color=435ebe&bold=true"
                                            alt="Avatar" class="rounded-circle shadow-sm">
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $service->operator->name }}</h6>
                                        <small class="text-muted">{{ $service->operator->email }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 border-top border-primary border-4">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <h5 class="card-title text-dark">
                            <i class="bi bi-graph-up-arrow me-2 text-primary"></i> Analisis Performa Layanan
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-center py-5 border rounded-3 border-dashed">
                            <div class="mb-3">
                                <i class="bi bi-bar-chart fs-1 text-muted opacity-50"></i>
                            </div>
                            <h6 class="text-muted">Data Riwayat Belum Tersedia</h6>
                            <p class="small text-muted mb-0 px-5">
                                Statistik rata-rata waktu layanan, jumlah antrean sukses, dan tingkat kepuasan akan muncul
                                di sini setelah layanan mulai beroperasi secara aktif.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
