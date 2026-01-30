@extends('dashboard.layouts.main')

@section('title', 'Detail Pemanggil')

@section('content')
    <section class="section">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('counters.index') }}" class="btn rounded-pill btn-warning">
                <i class="bi bi-chevron-left me-1"></i> Kembali
            </a>
            <a href="{{ route('counters.edit', $counter->id) }}" class="btn rounded-pill btn-primary shadow-sm px-4">
                <i class="bi bi-pencil-square me-1"></i> Edit Loket
            </a>
        </div>

        <div class="row">
            <div class="col-12 col-lg-8 mx-auto">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="bi bi-display fs-3"></i>
                                </div>
                                <div>
                                    <h4 class="text-dark mb-0">{{ $counter->name }}</h4>
                                </div>
                            </div>
                            <div>
                                @if ($counter->status == 'open')
                                    <span
                                        class="badge bg-light-success text-success border border-success px-3 py-2 rounded-pill">
                                        <i class="bi bi-circle-fill me-1 small"></i> Buka
                                    </span>
                                @elseif($counter->status == 'break')
                                    <span
                                        class="badge bg-light-warning text-warning border border-warning px-3 py-2 rounded-pill">
                                        <i class="bi bi-clock-history me-1 small"></i> Istirahat
                                    </span>
                                @else
                                    <span
                                        class="badge bg-light-danger text-danger border border-danger px-3 py-2 rounded-pill">
                                        <i class="bi bi-x-circle-fill me-1 small"></i> Tutup
                                    </span>
                                @endif
                            </div>
                        </div>

                        <hr class="opacity-25">

                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <h6 class="text-uppercase text-muted small fw-bold mb-3">Operator</h6>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-lg me-3">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($counter->operator->name) }}&background=f0f5ff&color=435ebe&bold=true"
                                            alt="Avatar" class="rounded-circle shadow-sm">
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $counter->operator->name }}</h6>
                                        <small class="text-muted">{{ $counter->operator->email }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 border-top border-primary border-4">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <h5 class="card-title text-dark">
                            <i class="bi bi-bar-chart-line me-2 text-primary"></i> Statistik & Performa
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-center py-5 border rounded-3 border-dashed">
                            <div class="mb-3">
                                <i class="bi bi-database-fill-add fs-1 text-muted opacity-50"></i>
                            </div>
                            <h6 class="text-muted">Data performa belum tersedia</h6>
                            <p class="small text-muted mb-0">Riwayat aktivitas dan statistik pelayanan akan muncul di sini
                                setelah loket digunakan.</p>
                        </div>

                        {{-- 
                        <div class="mt-4">
                            <canvas id="performanceChart"></canvas>
                        </div> 
                        --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
