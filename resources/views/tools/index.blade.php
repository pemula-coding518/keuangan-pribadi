@extends('layouts.app')

@section('content')

<div class="page-header mb-4">
    <h1 class="page-title">📂 Import / Export Data</h1>
    <p class="page-subtitle">Kelola file data transaksi keuangan Anda.</p>
</div>

<div class="row g-4">

    <div class="col-md-6">
        <div class="tool-card">

            <div class="tool-icon" style="background: rgba(16,185,129,0.14); border: 1px solid rgba(16,185,129,0.22);">
                📤
            </div>

            <h5 style="font-size:16px; font-weight:700; color:var(--text-1); margin-bottom:8px;">
                Export Data
            </h5>

            <p style="font-size:13.5px; color:var(--text-2); line-height:1.6; margin-bottom:24px;">
                Download seluruh data transaksi ke file CSV yang dapat dibuka di Excel atau aplikasi spreadsheet lainnya.
            </p>

            <a href="{{ route('transactions.export') }}" class="btn btn-success">
                📤 Export CSV
            </a>

        </div>
    </div>

    <div class="col-md-6">
        <div class="tool-card">

            <div class="tool-icon" style="background: rgba(99,102,241,0.14); border: 1px solid rgba(99,102,241,0.22);">
                📥
            </div>

            <h5 style="font-size:16px; font-weight:700; color:var(--text-1); margin-bottom:8px;">
                Import Data
            </h5>

            <p style="font-size:13.5px; color:var(--text-2); line-height:1.6; margin-bottom:24px;">
                Import transaksi dari file CSV untuk mengisi data secara massal. Fitur ini sedang dalam pengembangan.
            </p>

            <button class="btn btn-secondary" disabled>
                🔒 Segera Hadir
            </button>

        </div>
    </div>

</div>

@endsection