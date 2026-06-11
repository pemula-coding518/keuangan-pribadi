@extends('layouts.app')

@section('content')

    ```
    <!-- ===================================================== -->
    <!-- HEADER HALAMAN                                        -->
    <!-- ===================================================== -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <!-- Judul otomatis:
             Laporan Mingguan
             Laporan Bulanan
             Laporan Tahunan -->
        <h2 class="fw-bold">

            {{ $title }}

        </h2>

        <!-- Tombol kembali ke dashboard utama -->
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">

            ← Kembali

        </a>

    </div>

    <!-- ===================================================== -->
    <!-- DASHBOARD STATISTIK LAPORAN                           -->
    <!-- ===================================================== -->

    <div class="row g-3 mb-4">

        <!-- Total Pemasukan -->
        <div class="col-md-4">

            <div class="card border-0 shadow-lg bg-success text-white">

                <div class="card-body">

                    <h6>Total Pemasukan</h6>

                    <h3 class="fw-bold">

                        Rp {{ number_format($income, 0, ',', '.') }}

                    </h3>

                </div>

            </div>

        </div>

        <!-- Total Pengeluaran -->
        <div class="col-md-4">

            <div class="card border-0 shadow-lg bg-danger text-white">

                <div class="card-body">

                    <h6>Total Pengeluaran</h6>

                    <h3 class="fw-bold">

                        Rp {{ number_format($expense, 0, ',', '.') }}

                    </h3>

                </div>

            </div>

        </div>

        <!-- Sisa Saldo -->
        <div class="col-md-4">

            <div class="card border-0 shadow-lg bg-primary text-white">

                <div class="card-body">

                    <h6>Sisa Saldo</h6>

                    <h3 class="fw-bold">

                        Rp {{ number_format($balance, 0, ',', '.') }}

                    </h3>

                </div>

            </div>

        </div>

    </div>

    <!-- ===================================================== -->
    <!-- TABEL LAPORAN                                         -->
    <!-- ===================================================== -->

    <div class="card shadow border-0">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-primary">

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

                                <!-- Nomor -->
                                <td>

                                    {{ $loop->iteration }}

                                </td>

                                <!-- Judul -->
                                <td>

                                    {{ $item->title }}

                                </td>

                                <!-- Kategori -->
                                <td>

                                    {{ $item->category->name ?? '-' }}

                                </td>

                                <!-- Jenis transaksi -->
                                <td>

                                    @if($item->type == 'pemasukan')

                                        <span class="badge bg-success">

                                            ⬆ Pemasukan

                                        </span>

                                    @else

                                        <span class="badge bg-danger">

                                            ⬇ Pengeluaran

                                        </span>

                                    @endif

                                </td>

                                <!-- Nominal -->
                                <td>

                                    Rp {{ number_format($item->amount, 0, ',', '.') }}

                                </td>

                                <!-- Tanggal -->
                                <td>

                                    {{ \Carbon\Carbon::parse($item->transaction_date)->format('d-m-Y') }}

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="text-center text-muted">

                                    Tidak ada transaksi pada periode ini.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>
    ```

@endsection