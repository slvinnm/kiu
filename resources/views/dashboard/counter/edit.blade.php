@extends('dashboard.layouts.main')

@section('title', 'Edit Pemanggil')

@section('content')
    <section class="section">
        <div class="mb-3">
            <a href="{{ route('counters.index') }}" class="btn rounded-pill btn-warning">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <form action="{{ route('counters.update', $counter->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card shadow-sm">
                <div class="card-header bg-light-primary">
                    <h5 class="card-title">1. Data Loket</h5>
                </div>
                <div class="card-body mt-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Nama Pemanggil / Loket</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $counter->name) }}"
                                    placeholder="Contoh: Loket 1 atau Customer Service A">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-light-primary">
                    <h5 class="card-title">2. Operator</h5>
                </div>
                <div class="card-body mt-3">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="user_name" class="form-label">Nama Operator</label>
                                <input type="text" class="form-control @error('user_name') is-invalid @enderror"
                                    id="user_name" name="user_name"
                                    value="{{ old('user_name', $counter->operator->name ?? '') }}"
                                    placeholder="Nama Lengkap">
                                @error('user_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email"
                                    value="{{ old('email', $counter->operator->email ?? '') }}"
                                    placeholder="email@example.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">Password Baru</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="Kosongkan jika tidak diganti">
                                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah password.</small>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn rounded-pill btn-primary">
                        <i class="bi bi-check-circle me-1"></i> Perbarui Data
                    </button>
                </div>
            </div>
        </form>
    </section>
@endsection
