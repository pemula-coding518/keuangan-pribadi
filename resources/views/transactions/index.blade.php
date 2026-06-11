@extends('layouts.app')

@section('content')

    <!-- ===================================================== -->
    <!-- HEADER HALAMAN                                        -->
    <!-- ===================================================== -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="fw-bold">

            📊 Data Keuangan

        </h2>

        <!-- Tombol tambah transaksi -->
        <a href="{{ route('transactions.create') }}" class="btn btn-primary">

            + Tambah Data

        </a>

    </div>

    <!-- ===================================================== -->
    <!-- DASHBOARD STATISTIK                                   -->
    <!-- ===================================================== -->

    <div class="row g-3 mb-4">

        <!-- Total Pemasukan -->
        <div class="col-md-4">

            <div class="card border-0 shadow-lg bg-success text-white">

                <div class="card-body">

                    <h6>Total Pemasukan</h6>

                    <h3 class="fw-bold">

                        Rp {{ number_format($totalIncome, 0, ',', '.') }}

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

                        Rp {{ number_format($totalExpense, 0, ',', '.') }}

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
    <!-- DASHBOARD RINGKASAN KEUANGAN                          -->
    <!-- ===================================================== -->

    <h4 class="mb-3">

        📈 Ringkasan Keuangan

    </h4>

    <div class="row g-3 mb-4">

        <!-- ================================================= -->
        <!-- LAPORAN MINGGUAN                                  -->
        <!-- ================================================= -->

        <div class="col-md-4">

            <!--
                Ketika card diklik:
                /report/weekly
            -->
            <a href="{{ route('transactions.report', 'weekly') }}" class="text-decoration-none text-dark">

                <div class="card shadow border-0 h-100">

                    <div class="card-body">

                        <h5 class="fw-bold">

                            📅 Minggu Ini

                        </h5>

                        <hr>

                        <!-- Total pemasukan minggu ini -->
                        <p class="text-success mb-1">

                            Pemasukan :
                            Rp {{ number_format($weeklyIncome, 0, ',', '.') }}

                        </p>

                        <!-- Total pengeluaran minggu ini -->
                        <p class="text-danger mb-3">

                            Pengeluaran :
                            Rp {{ number_format($weeklyExpense, 0, ',', '.') }}

                        </p>

                        <!-- Petunjuk klik -->
                        <small class="text-primary">

                            Lihat Detail Laporan →

                        </small>

                    </div>

                </div>

            </a>

        </div>

        <!-- ================================================= -->
        <!-- LAPORAN BULANAN                                   -->
        <!-- ================================================= -->

        <div class="col-md-4">

            <a href="{{ route('transactions.report', 'monthly') }}" class="text-decoration-none text-dark">

                <div class="card shadow border-0 h-100">

                    <div class="card-body">

                        <h5 class="fw-bold">

                            📆 Bulan Ini

                        </h5>

                        <hr>

                        <p class="text-success mb-1">

                            Pemasukan :
                            Rp {{ number_format($monthlyIncome, 0, ',', '.') }}

                        </p>

                        <p class="text-danger mb-3">

                            Pengeluaran :
                            Rp {{ number_format($monthlyExpense, 0, ',', '.') }}

                        </p>

                        <small class="text-primary">

                            Lihat Detail Laporan →

                        </small>

                    </div>

                </div>

            </a>

        </div>

        <!-- ================================================= -->
        <!-- LAPORAN TAHUNAN                                   -->
        <!-- ================================================= -->

        <div class="col-md-4">

            <a href="{{ route('transactions.report', 'yearly') }}" class="text-decoration-none text-dark">

                <div class="card shadow border-0 h-100">

                    <div class="card-body">

                        <h5 class="fw-bold">

                            🗓️ Tahun Ini

                        </h5>

                        <hr>

                        <p class="text-success mb-1">

                            Pemasukan :
                            Rp {{ number_format($yearlyIncome, 0, ',', '.') }}

                        </p>

                        <p class="text-danger mb-3">

                            Pengeluaran :
                            Rp {{ number_format($yearlyExpense, 0, ',', '.') }}

                        </p>

                        <small class="text-primary">

                            Lihat Detail Laporan →

                        </small>

                    </div>

                </div>

            </a>

        </div>

    </div>

    <!-- ===================================================== -->
    <!-- ALERT SUKSES                                          -->
    <!-- ===================================================== -->

    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

        </div>

    @endif

    <!-- ===================================================== -->
    <!-- TABEL TRANSAKSI                                       -->
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
                            <th width="18%">Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($transactions as $item)

                                        <tr>

                                            <!-- Nomor -->
                                            <td>

                                                {{
                            ($transactions->currentPage() - 1)
                            * $transactions->perPage()
                            + $loop->iteration
                                                                                                                                    }}

                                            </td>

                                            <!-- Judul -->
                                            <td>

                                                {{ $item->title }}

                                            </td>

                                            <!-- Kategori -->
                                            <td>

                                                {{ $item->category->name ?? '-' }}

                                            </td>

                                            <!-- Jenis -->
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

                                            <!-- Jumlah -->
                                            <td>

                                                Rp {{ number_format($item->amount, 0, ',', '.') }}

                                            </td>

                                            <!-- Tanggal -->
                                            <td>

                                                {{ \Carbon\Carbon::parse($item->transaction_date)->format('d-m-Y') }}

                                            </td>

                                            <!-- Tombol Aksi -->
                                            <td>

                                                <!-- Tombol Edit -->
                                                <a href="{{ route('transactions.edit', $item->id) }}"
                                                    class="btn btn-outline-warning btn-sm">

                                                    ✏ Edit

                                                </a>

                                                <!-- Form Hapus -->
                                                <form action="{{ route('transactions.destroy', $item->id) }}" method="POST"
                                                    class="d-inline">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                                        onclick="return confirm('Yakin ingin menghapus data ini?')">

                                                        🗑 Hapus

                                                    </button>

                                                </form>

                                            </td>

                                        </tr>

                        @empty

                            <tr>

                                <td colspan="7" class="text-center text-muted">

                                    Data transaksi belum tersedia.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <!-- ===================================================== -->
    <!-- PAGINATION                                            -->
    <!-- ===================================================== -->

    <div class="mt-4">

        {{ $transactions->links() }}

    </div>

@endsection