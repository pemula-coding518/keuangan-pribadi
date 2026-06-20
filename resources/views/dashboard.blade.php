@extends('layouts.app')

@section('content')

<div class="page-header mb-4">
    <h1 class="page-title">📊 Dashboard Keuangan</h1>
    <p class="page-subtitle">Ringkasan keuangan Anda secara keseluruhan.</p>
</div>

<!-- ===================================================== -->
<!-- STAT CARDS                                            -->
<!-- ===================================================== -->

<div class="row g-3 mb-4">

    <div class="col-md-3">
        <div class="stat-card success-card">
            <div class="stat-title">Total Pemasukan</div>
            <div class="stat-value text-income">
                Rp {{ number_format($income, 0, ',', '.') }}
            </div>
            <div class="stat-icon green">📈</div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card danger-card">
            <div class="stat-title">Total Pengeluaran</div>
            <div class="stat-value text-expense">
                Rp {{ number_format($expense, 0, ',', '.') }}
            </div>
            <div class="stat-icon red">📉</div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-title">Saldo</div>
            <div class="stat-value text-balance">
                Rp {{ number_format($balance, 0, ',', '.') }}
            </div>
            <div class="stat-icon blue">💰</div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-title">Total Transaksi</div>
            <div class="stat-value">
                {{ $transactionCount }}
            </div>
            <div class="stat-icon amber">📋</div>
        </div>
    </div>

</div>

<!-- ===================================================== -->
<!-- TABEL TRANSAKSI TERBARU                               -->
<!-- ===================================================== -->

<div class="card">

    <div class="card-header">
        <h5 class="section-title">🕒 Transaksi Terbaru</h5>
    </div>

    <div class="table-responsive">
        <table class="table">

            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                </tr>
            </thead>

            <tbody>

                @forelse($latestTransactions as $transaction)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d-m-Y') }}</td>
                        <td class="category-col">{{ $transaction->category->name ?? '-' }}</td>
                        <td>Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">
                            <div class="empty-state">
                                <div class="ei">📂</div>
                                <h5>Belum ada transaksi</h5>
                                <p>Tambahkan transaksi pertama Anda.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse

            </tbody>

        </table>
    </div>

</div>

@endsection