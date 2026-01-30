@extends('dashboard.layouts.main')

@section('title', 'Layanan')

@section('css')
    <link rel="stylesheet" href="{{ asset('theme/dashboard/assets/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('theme/dashboard/assets/compiled/css/table-datatable.css') }}">
@endsection

@section('content')
    <section class="section">
        <div class="mb-3">
            <a href="{{ route('services.create') }}" class="btn rounded-pill btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Tambah Layanan
            </a>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    Data Layanan
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-hover" id="table1">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%" class="text-center">#</th>
                            <th>Nama</th>
                            <th>Kode</th>
                            <th>Status</th>
                            <th>Operator</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($services as $service)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $service->name }}</td>
                                <td>{{ $service->code }}</td>
                                <td>
                                    <form action="{{ route('services.toggle-status', $service) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="status-switch-{{ $service->id }}" name="is_active"
                                                onchange="this.form.submit()" {{ $service->is_active ? 'checked' : '' }}>

                                            <label class="form-check-label" for="status-switch-{{ $service->id }}">
                                                {{ $service->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                            </label>
                                        </div>
                                    </form>
                                </td>
                                <td>{{ $service->operator->name }}</td>
                                <td >
                                    <div class="d-flex gap-2 mb-2 justify-content-center">
                                        <a href="{{ route('services.routes.index', $service) }}"
                                            class="btn rounded-pill btn-sm btn-secondary">
                                            <i class="bi bi-signpost-split me-1"></i> Rute Layanan
                                        </a>
                                        <a href="{{ route('services.edit', $service) }}"
                                            class="btn rounded-pill btn-sm btn-primary">
                                            <i class="bi bi-pencil-square me-1"></i> Edit
                                        </a>
                                        <a href="{{ route('services.show', $service) }}"
                                            class="btn rounded-pill btn-sm btn-info">
                                            <i class="bi bi-eye me-1"></i> Detail
                                        </a>
                                        <form action="{{ route('services.destroy', $service) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn rounded-pill btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus pengguna ini?')">
                                                <i class="bi bi-trash me-1"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="{{ asset('theme/dashboard/assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('theme/dashboard/assets/static/js/pages/simple-datatables.js') }}"></script>
@endsection
