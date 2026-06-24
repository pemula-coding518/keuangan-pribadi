@extends('layouts.app')

@section('content')

<!-- ===================================================== -->
<!-- PAGE HEADER                                           -->
<!-- ===================================================== -->

<div class="page-header">

    <h1 class="page-title">
        {{ $title }}
    </h1>

    <p class="page-subtitle">
        Ringkasan transaksi pada periode yang dipilih
    </p>

</div>

<!-- ===================================================== -->
<!-- BACK BUTTON                                           -->
<!-- ===================================================== -->

<div class="mb-4">

    <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
        <i class="ti ti-arrow-left"></i> Kembali
    </a>

</div>

<!-- ===================================================== -->
<!-- PERIOD INFO CARD                                      -->
<!-- ===================================================== -->

<div class="card mb-4">

    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <div class="stat-title">Periode Laporan</div>

                <div class="stat-value" style="font-size:18px;">

                    @if(Str::contains($title, 'Mingguan'))
                        Minggu Ini
                    @elseif(Str::contains($title, 'Bulanan'))
                        Bulan Ini
                    @else
                        Tahun Ini
                    @endif

                </div>

            </div>

            <div style="font-size:30px; color:var(--blue-300);">
                <i class="ti ti-calendar"></i>
            </div>

        </div>

    </div>

</div>

<!-- ===================================================== -->
<!-- STAT CARDS                                           -->
<!-- ===================================================== -->

<div class="row g-3 mb-5">

    <!-- INCOME -->
    <div class="col-md-4">

        <div class="stat-card success-card">

            <div class="stat-title"><i class="ti ti-trending-up"></i> Total Pemasukan</div>

            <div class="stat-value text-income">
                Rp {{ number_format($income, 0, ',', '.') }}
            </div>

            <div class="stat-icon green"><i class="ti ti-trending-up"></i></div>

        </div>

    </div>

    <!-- EXPENSE -->
    <div class="col-md-4">

        <div class="stat-card danger-card">

            <div class="stat-title"><i class="ti ti-trending-down"></i> Total Pengeluaran</div>

            <div class="stat-value text-expense">
                Rp {{ number_format($expense, 0, ',', '.') }}
            </div>

            <div class="stat-icon red"><i class="ti ti-trending-down"></i></div>

        </div>

    </div>

    <!-- BALANCE -->
    <div class="col-md-4">

        <div class="stat-card">

            <div class="stat-title"><i class="ti ti-wallet"></i> Sisa Saldo</div>

            <div class="stat-value text-balance">
                Rp {{ number_format($balance, 0, ',', '.') }}
            </div>

            <div class="stat-icon blue"><i class="ti ti-wallet"></i></div>

        </div>

    </div>

</div>

<!-- ===================================================== -->
<!-- TABLE CARD                                            -->
<!-- ===================================================== -->

<div class="card">

    <!-- HEADER -->
    <div class="card-header">

        <h5 class="section-title mb-0"><i class="ti ti-list-details"></i> Daftar Transaksi</h5>

    </div>

    <!-- TABLE -->
    <div class="table-responsive">

        <table class="table">

            <thead>

                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Jenis</th>
                    <th>Jumlah</th>
                    <th>Tanggal</th>
                </tr>

            </thead>

            <tbody>

                @forelse($transactions as $item)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td class="transaction-title">
                            {{ $item->title }}
                        </td>

                        <td class="category-col">
                            {{ $item->category->name ?? '-' }}
                        </td>

                        <td>

                            @if($item->type == 'pemasukan')

                                <span class="income-badge">
                                    <i class="ti ti-arrow-up-right"></i> Pemasukan
                                </span>

                            @else

                                <span class="expense-badge">
                                    <i class="ti ti-arrow-down-right"></i> Pengeluaran
                                </span>

                            @endif

                        </td>

                        <td>
                            Rp {{ number_format($item->amount, 0, ',', '.') }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($item->transaction_date)->format('d-m-Y') }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6">

                            <div class="empty-state">

                                <div class="ei"><i class="ti ti-inbox"></i></div>

                                <h5>Tidak ada transaksi</h5>

                                <p>Belum ada transaksi pada periode ini.</p>

                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection