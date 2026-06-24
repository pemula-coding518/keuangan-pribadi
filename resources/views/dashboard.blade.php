@extends('layouts.app')

@section('content')

<div class="page-header mb-4">
    <h1 class="page-title"><i class="ti ti-layout-dashboard"></i> Dashboard Keuangan</h1>
    <p class="page-subtitle">Ringkasan keuangan Anda secara keseluruhan.</p>
</div>

<!-- ===================================================== -->
<!-- STAT CARDS                                            -->
<!-- ===================================================== -->

<div class="row g-3 mb-4">

    <div class="col-md-3">
        <div class="stat-card success-card">
            <div class="stat-title"><i class="ti ti-trending-up"></i> Total Pemasukan</div>
            <div class="stat-value text-income">
                Rp {{ number_format($income, 0, ',', '.') }}
            </div>
            <div class="stat-icon green"><i class="ti ti-trending-up"></i></div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card danger-card">
            <div class="stat-title"><i class="ti ti-trending-down"></i> Total Pengeluaran</div>
            <div class="stat-value text-expense">
                Rp {{ number_format($expense, 0, ',', '.') }}
            </div>
            <div class="stat-icon red"><i class="ti ti-trending-down"></i></div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-title"><i class="ti ti-wallet"></i> Saldo</div>
            <div class="stat-value text-balance">
                Rp {{ number_format($balance, 0, ',', '.') }}
            </div>
            <div class="stat-icon blue"><i class="ti ti-wallet"></i></div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-title"><i class="ti ti-list-details"></i> Total Transaksi</div>
            <div class="stat-value">
                {{ $transactionCount }}
            </div>
            <div class="stat-icon amber"><i class="ti ti-list-details"></i></div>
        </div>
    </div>

</div>

<!-- ===================================================== -->
<!-- TABEL TRANSAKSI TERBARU                               -->
<!-- ===================================================== -->

<div class="card">

    <div class="card-header">
        <h5 class="section-title"><i class="ti ti-clock"></i> Transaksi Terbaru</h5>
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
                                <div class="ei"><i class="ti ti-inbox"></i></div>
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