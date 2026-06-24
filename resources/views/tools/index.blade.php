@extends('layouts.app')

@section('content')

<div class="page-header mb-4">
    <h1 class="page-title"><i class="ti ti-file-export"></i> Import / Export Data</h1>
    <p class="page-subtitle">Kelola file data transaksi keuangan Anda.</p>
</div>

@if(session('error'))
    <div class="alert alert-danger mb-4">
        <i class="ti ti-alert-circle"></i>
        {{ session('error') }}
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success mb-4">
        <i class="ti ti-circle-check"></i>
        {{ session('success') }}
    </div>
@endif

@if(session('import_skipped') && count(session('import_skipped')) > 0)
    <div class="alert alert-warning mb-4" style="align-items:flex-start;">
        <i class="ti ti-alert-triangle" style="margin-top:1px;"></i>
        <div>
            <strong>{{ count(session('import_skipped')) }} baris dilewati:</strong>
            <ul class="mb-0 mt-1" style="padding-left:18px;">
                @foreach(array_slice(session('import_skipped'), 0, 10) as $msg)
                    <li>{{ $msg }}</li>
                @endforeach
                @if(count(session('import_skipped')) > 10)
                    <li>...dan {{ count(session('import_skipped')) - 10 }} baris lainnya.</li>
                @endif
            </ul>
        </div>
    </div>
@endif

<div class="row g-4">

    <div class="col-md-6">
        <div class="tool-card">

            <div class="tool-icon" style="background: rgba(16,185,129,0.14); border: 1px solid rgba(16,185,129,0.22); color:#4ade80;">
                <i class="ti ti-upload"></i>
            </div>

            <h5 class="tool-title">Export Data</h5>

            <p class="tool-desc">
                Download seluruh data transaksi ke file CSV yang dapat dibuka di Excel atau aplikasi spreadsheet lainnya.
            </p>

            <a href="{{ route('transactions.export') }}" class="btn btn-success">
                <i class="ti ti-upload"></i> Export CSV
            </a>

        </div>
    </div>

    <div class="col-md-6">
        <div class="tool-card">

            <div class="tool-icon" style="background: rgba(99,102,241,0.14); border: 1px solid rgba(99,102,241,0.22); color:#a5b4fc;">
                <i class="ti ti-download"></i>
            </div>

            <h5 class="tool-title">Import Data</h5>

            <p class="tool-desc">
                Unggah file CSV untuk menambahkan banyak transaksi sekaligus.
                <a href="{{ route('transactions.import.template') }}" style="color:var(--blue-400);">
                    Unduh template CSV
                </a>
                untuk melihat format kolom yang dibutuhkan.
            </p>

            <form action="{{ route('transactions.import') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-3">
                    <input
                        type="file"
                        name="csv_file"
                        class="form-control"
                        accept=".csv,text/csv"
                        required
                    >
                </div>

                <div class="mb-3" style="display:flex; align-items:center; gap:8px;">
                    <input
                        type="checkbox"
                        name="auto_create_category"
                        id="autoCreateCategory"
                        value="1"
                        checked
                        style="width:16px; height:16px; accent-color:var(--blue-500);"
                    >
                    <label for="autoCreateCategory" style="font-size:12.5px; color:var(--text-2); margin:0;">
                        Buat kategori otomatis jika belum ada
                    </label>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-download"></i> Import CSV
                </button>
            </form>

        </div>
    </div>

</div>

@endsection