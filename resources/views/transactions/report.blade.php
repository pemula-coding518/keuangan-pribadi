@extends('layouts.app')

@section('content')

<div class="report-header">

<div class="d-flex justify-content-between align-items-center">

    <div class="d-flex align-items-center gap-3">

        <div class="report-icon">
            📊
        </div>

        <div>

            <h1 class="page-title mb-1">
                {{ $title }}
            </h1>

            <p class="text-secondary mb-0">
                Ringkasan transaksi pada periode yang dipilih
            </p>

        </div>

    </div>

    <a href="{{ route('transactions.index') }}"
       class="btn-action-edit">

        ← Kembali

    </a>

</div>

</div>

<div class="card period-card mb-5">

<div class="card-body">

    <div class="d-flex justify-content-between align-items-center">

        <div>

            <small class="text-secondary">
                Periode Laporan
            </small>

            <h4 class="fw-bold mb-0">

                @if(Str::contains($title, 'Mingguan'))
                    Minggu Ini
                @elseif(Str::contains($title, 'Bulanan'))
                    Bulan Ini
                @else
                    Tahun Ini
                @endif

            </h4>

        </div>

        <div class="fs-3">
            📅
        </div>

    </div>

</div>

</div>

<div class="row g-4 mb-5">

<div class="col-md-4">

    <div class="stat-card">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <div class="stat-title">
                    Total Pemasukan
                </div>

                <div class="stat-value text-income">
                    Rp {{ number_format($income, 0, ',', '.') }}
                </div>

            </div>

            <div style="font-size:40px">
                📈
            </div>

        </div>

    </div>

</div>

<div class="col-md-4">

    <div class="stat-card">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <div class="stat-title">
                    Total Pengeluaran
                </div>

                <div class="stat-value text-expense">
                    Rp {{ number_format($expense, 0, ',', '.') }}
                </div>

            </div>

            <div style="font-size:40px">
                📉
            </div>

        </div>

    </div>

</div>

<div class="col-md-4">

    <div class="stat-card">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <div class="stat-title">
                    Sisa Saldo
                </div>

                <div class="stat-value text-warning">
                    Rp {{ number_format($balance, 0, ',', '.') }}
                </div>

            </div>

            <div style="font-size:40px">
                💰
            </div>

        </div>

    </div>

</div>

</div>

<div class="card overflow-hidden">

<div class="card-header border-0 py-4">

    <h4 class="table-section-title mb-0">
        📋 Daftar Transaksi
    </h4>

</div>

<div class="table-responsive">

    <table class="table table-dark-luxury align-middle mb-0">

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

                    <td class="category-column">
                        {{ $item->category->name ?? '-' }}
                    </td>

                    <td>

                        @if($item->type == 'pemasukan')

                            <span class="income-badge">
                                ↑ Pemasukan
                            </span>

                        @else

                            <span class="expense-badge">
                                ↓ Pengeluaran
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

                        <div class="empty-state text-center">

                            <div class="empty-icon">
                                📂
                            </div>

                            <h4 class="mt-3">
                                Tidak ada transaksi
                            </h4>

                            <p class="text-secondary mb-0">
                                Belum ada transaksi pada periode ini.
                            </p>

                        </div>

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>


</div>

@endsection
