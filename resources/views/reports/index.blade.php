@extends('layouts.app')

@section('content')

<div class="container">

    <h1 class="mb-4">
        📈 Laporan Keuangan
    </h1>

    <p class="text-muted mb-4">
        Pilih periode laporan yang ingin ditampilkan.
    </p>

    <div class="row">

        <div class="col-md-4 mb-3">

            <div class="card h-100">

                <div class="card-body">

                    <h4>📅 Mingguan</h4>

                    <p>
                        Ringkasan transaksi minggu ini.
                    </p>

                    <a
                        href="{{ route('transactions.report', 'weekly') }}"
                        class="btn btn-primary">

                        Lihat Laporan

                    </a>

                </div>

            </div>

        </div>

        <div class="col-md-4 mb-3">

            <div class="card h-100">

                <div class="card-body">

                    <h4>🗓️ Bulanan</h4>

                    <p>
                        Ringkasan transaksi bulan ini.
                    </p>

                    <a
                        href="{{ route('transactions.report', 'monthly') }}"
                        class="btn btn-primary">

                        Lihat Laporan

                    </a>

                </div>

            </div>

        </div>

        <div class="col-md-4 mb-3">

            <div class="card h-100">

                <div class="card-body">

                    <h4>📆 Tahunan</h4>

                    <p>
                        Ringkasan transaksi tahun ini.
                    </p>

                    <a
                        href="{{ route('transactions.report', 'yearly') }}"
                        class="btn btn-primary">

                        Lihat Laporan

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection