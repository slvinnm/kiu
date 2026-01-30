@extends('dashboard.layouts.main')

@section('title', 'Pemanggil')

@section('css')
    <link rel="stylesheet" href="{{ asset('theme/dashboard/assets/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('theme/dashboard/assets/compiled/css/table-datatable.css') }}">
@endsection

@section('page-heading')
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Pemanggil</h3>
                <p class="text-subtitle text-muted">List data pemanggil</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pemanggil</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section class="section">
        <div class="mb-3">
            <a href="{{ route('counters.create') }}" class="btn rounded-pill btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Tambah Pemanggil
            </a>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    Data Pemanggil
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Operator</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($counters as $counter)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $counter->name }}</td>
                                <td>
                                    @if ($counter->status == 'open')
                                        <span
                                            class="badge bg-light-success text-success border border-success px-3 py-2 rounded-pill shadow-sm"
                                            style="font-weight: 600;">
                                            <i class="bi bi-circle-fill me-1 small"></i> Buka
                                        </span>
                                    @elseif($counter->status == 'break')
                                        <span
                                            class="badge bg-light-warning text-warning border border-warning px-3 py-2 rounded-pill shadow-sm"
                                            style="font-weight: 600;">
                                            <i class="bi bi-clock-history me-1 small"></i> Istirahat
                                        </span>
                                    @else
                                        <span
                                            class="badge bg-light-danger text-danger border border-danger px-3 py-2 rounded-pill shadow-sm"
                                            style="font-weight: 600;">
                                            <i class="bi bi-x-circle-fill me-1 small"></i> Tutup
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $counter->operator->name }}</td>
                                <td>
                                    <a href="{{ route('counters.edit', $counter) }}"
                                        class="btn rounded-pill btn-sm btn-primary">
                                        <i class="bi bi-pencil-square me-1"></i> Edit
                                    </a>

                                    <a href="{{ route('counters.show', $counter) }}"
                                        class="btn rounded-pill btn-sm btn-info">
                                        <i class="bi bi-eye me-1"></i> Detail
                                    </a>

                                    <form action="{{ route('counters.destroy', $counter) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn rounded-pill btn-sm btn-danger"
                                            onclick="return confirm('Yakin ingin menghapus pemanggil ini?')">
                                            <i class="bi bi-trash me-1"></i> Hapus
                                        </button>
                                    </form>
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
