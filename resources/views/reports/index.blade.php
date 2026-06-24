@extends('layouts.app')

@section('content')

<div class="page-header mb-4">
    <h1 class="page-title"><i class="ti ti-chart-line"></i> Laporan Keuangan</h1>
    <p class="page-subtitle">Pilih periode laporan yang ingin ditampilkan.</p>
</div>

<div class="row g-4">

    <div class="col-md-4">
        <a href="{{ route('transactions.report', 'weekly') }}" class="report-option">
            <div class="report-option-icon"><i class="ti ti-calendar-week"></i></div>
            <div class="report-option-title">Laporan Mingguan</div>
            <div class="report-option-desc">
                Ringkasan transaksi minggu ini. Pantau pola keuangan terkini dengan mudah.
            </div>
            <div class="report-option-arrow">Lihat Laporan →</div>
        </a>
    </div>

    <div class="col-md-4">
        <a href="{{ route('transactions.report', 'monthly') }}" class="report-option">
            <div class="report-option-icon"><i class="ti ti-calendar-month"></i></div>
            <div class="report-option-title">Laporan Bulanan</div>
            <div class="report-option-desc">
                Ringkasan transaksi bulan ini. Evaluasi anggaran dan pencapaian keuangan bulanan.
            </div>
            <div class="report-option-arrow">Lihat Laporan →</div>
        </a>
    </div>

    <div class="col-md-4">
        <a href="{{ route('transactions.report', 'yearly') }}" class="report-option">
            <div class="report-option-icon"><i class="ti ti-calendar-stats"></i></div>
            <div class="report-option-title">Laporan Tahunan</div>
            <div class="report-option-desc">
                Ringkasan transaksi tahun ini. Lihat gambaran besar performa keuangan Anda.
            </div>
            <div class="report-option-arrow">Lihat Laporan →</div>
        </a>
    </div>

</div>

@endsection