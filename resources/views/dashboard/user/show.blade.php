@extends('dashboard.layouts.main')

@section('title', 'Detail Pengguna')

@section('page-heading')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Detail Pengguna</h3>
                <p class="text-subtitle text-muted">Informasi detail data pengguna</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Pengguna</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail Pengguna</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section class="section">
        <div class="mb-3">
            <a href="{{ route('users.index') }}" class="btn rounded-pill btn-warning">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Data Pengguna: {{ $user->name }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    {{-- Left Column: Account Info --}}
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" class="form-control" value="{{ $user->name }}" disabled>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Username</label>
                            <input type="text" class="form-control" value="{{ $user->username }}" disabled>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="text" class="form-control" value="{{ $user->email }}" disabled>
                        </div>
                    </div>

                    {{-- Right Column: Role & Location --}}
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Role / Jabatan</label>
                            <input type="text" class="form-control" value="{{ $user->role->name ?? 'Tidak ada role' }}"
                                disabled>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Loket / Counter</label>
                            <input type="text" class="form-control" value="{{ $user->counter->name ?? '-' }}" disabled>
                            @if (!$user->counter)
                                <small class="text-muted">User ini tidak terikat dengan loket manapun
                                    (Administrator).</small>
                            @endif
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Terdaftar Pada</label>
                            <input type="text" class="form-control" value="{{ $user->created_at->format('d M Y, H:i') }}"
                                disabled>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <a href="{{ route('users.edit', $user->id) }}" class="btn rounded-pill btn-info text-white">
                    <i class="bi bi-pencil-square me-1"></i> Edit Data
                </a>
            </div>
        </div>
    </section>
@endsection
