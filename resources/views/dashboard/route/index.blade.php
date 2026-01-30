@extends('dashboard.layouts.main')

@section('title', 'Rute Layanan - ' . $service->name)


@section('css')
    <style>
        .timeline {
            position: relative;
        }

        .timeline-dot {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            z-index: 2;
            flex-shrink: 0;
        }

        .timeline-line {
            position: absolute;
            left: 17px;
            top: 50%;
            bottom: -50%;
            width: 2px;
            background-color: #e9ecef;
            z-index: 1;
        }

        .timeline .d-flex:last-child .timeline-line {
            display: none;
        }
    </style>
@endsection

@section('content')
    <section class="section">
        <div class="mb-4">
            <a href="{{ route('services.index') }}" class="btn rounded-pill btn-warning">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="row">
            <div class="col-md-7">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light-primary py-3">
                        <h5 class="card-title mb-0">Alur Antrean</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="timeline">
                            @forelse($service->routesFrom->sortBy('step_order') as $index => $route)
                                <div class="d-flex align-items-center mb-4 position-relative">
                                    <div class="timeline-line"></div>
                                    <div class="timeline-dot bg-info shadow-sm text-white">
                                        {{ $index + 1 }}
                                    </div>
                                    <div class="ms-4 p-3 rounded-3 border flex-grow-1 border-primary border-2 shadow-sm">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <small
                                                    class="text-primary fw-bold text-uppercase">{{ $route->toService->name }}</small>
                                                <h6 class="mb-0 text-dark font-monospace">{{ $route->toService->code }}</h6>
                                            </div>
                                            <form
                                                action="{{ route('services.routes.destroy', ['service' => $service, 'route' => $route]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-sm btn-outline-danger border-0 rounded-circle"
                                                    onclick="return confirm('Hapus rute ini?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 opacity-50">
                                    <p class="small">Belum ada rute lanjutan setelah Loket.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="card-title mb-0 text-white">Tambah Langkah Rute</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('services.routes.store', $service) }}" method="POST">
                            @csrf

                            <div class="form-group mb-4">
                                <label class="form-label fw-bold">Pilih Layanan Tujuan</label>
                                <select name="to_service_id"
                                    class="form-select @error('to_service_id') is-invalid @enderror">
                                    <option value="" selected disabled>-- Pilih Tujuan --</option>
                                    @foreach ($services as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->code }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('to_service_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label fw-bold">Urutan Langkah (Step)</label>
                                <input type="number" name="step_order" class="form-control"
                                    value="{{ $service->routesFrom->count() + 1 }}" readonly>
                                <small class="text-muted">Urutan ditentukan secara otomatis berdasarkan jumlah rute saat
                                    ini.</small>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 rounded-pill py-2">
                                <i class="bi bi-plus-circle me-1"></i> Hubungkan Rute
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
