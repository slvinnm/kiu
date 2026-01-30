@extends('dashboard.layouts.main')

@section('title', 'Tambah Pengguna')

@section('content')
    <section class="section">
        <div class="mb-3">
            <a href="{{ route('users.index') }}" class="btn rounded-pill btn-warning">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Data Pengguna</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}"
                                    placeholder="Contoh: John Doe">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror"
                                    id="username" name="username" value="{{ old('username') }}" placeholder="johndoe123">
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}"
                                    placeholder="email@example.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation">
                            </div>

                            <hr>

                            <div class="form-group mb-3">
                                <label class="form-label d-block">Role / Jabatan</label>
                                @foreach ($roles as $role)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input role-radio" type="radio" name="role_id"
                                            id="role_{{ $role->id }}" value="{{ $role->id }}"
                                            {{ old('role_id') == $role->id ? 'checked' : '' }}>
                                        <label class="form-check-label" for="role_{{ $role->id }}">
                                            {{ $role->name }}
                                        </label>
                                    </div>
                                @endforeach
                                @error('role_id')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3" id="counter-container">
                                <label for="counter_id" class="form-label">Loket / Pemanggil</label>
                                <select class="form-select @error('counter_id') is-invalid @enderror" id="counter_id"
                                    name="counter_id">
                                    <option value="" disabled>-- Pilih Loket --</option>
                                    @foreach ($counters as $counter)
                                        <option value="{{ $counter->id }}"
                                            {{ old('counter_id') == $counter->id ? 'selected' : '' }}>
                                            {{ $counter->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('counter_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn rounded-pill btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan Pengguna
                    </button>
                </div>
            </div>
        </form>
    </section>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleRadios = document.querySelectorAll('.role-radio');
            const counterContainer = document.getElementById('counter-container');
            const counterSelect = document.getElementById('counter_id');

            const STAFF_ROLE_ID = @json(\App\Models\Role::COUNTER);

            function toggleCounter() {
                const selectedRole = document.querySelector('input[name="role_id"]:checked');

                if (selectedRole) {
                    if (selectedRole.value == STAFF_ROLE_ID) {
                        counterContainer.style.display = 'block';
                    } else {
                        counterContainer.style.display = 'none';
                        counterSelect.value = '';
                    }
                } else {
                    counterContainer.style.display = 'none';
                }
            }

            roleRadios.forEach(radio => {
                radio.addEventListener('change', toggleCounter);
            });

            toggleCounter();
        });
    </script>
@endsection
