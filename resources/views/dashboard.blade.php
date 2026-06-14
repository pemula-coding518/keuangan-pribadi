@extends('layouts.app')

@section('content')

<div class="container">

    <h2 class="mb-4">
        Dashboard Keuangan
    </h2>

    <div class="row">

        <!-- Pemasukan -->
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    <h5>Total Pemasukan</h5>
                    <h3>Rp {{ number_format($income,0,',','.') }}</h3>
                </div>
            </div>
        </div>

        <!-- Pengeluaran -->
        <div class="col-md-3 mb-3">
            <div class="card bg-danger text-white shadow">
                <div class="card-body">
                    <h5>Total Pengeluaran</h5>
                    <h3>Rp {{ number_format($expense,0,',','.') }}</h3>
                </div>
            </div>
        </div>

        <!-- Saldo -->
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    <h5>Saldo</h5>
                    <h3>Rp {{ number_format($balance,0,',','.') }}</h3>
                </div>
            </div>
        </div>

        <!-- Transaksi -->
        <div class="col-md-3 mb-3">
            <div class="card bg-warning shadow">
                <div class="card-body">
                    <h5>Jumlah Transaksi</h5>
                    <h3>{{ $transactionCount }}</h3>
                </div>
            </div>
        </div>

    </div>

    <!-- Transaksi terbaru -->
    <div class="card shadow mt-4">
        <div class="card-header">
            Transaksi Terbaru
        </div>

        <div class="card-body">

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
                            <td>{{ $transaction->transaction_date }}</td>
                            <td>{{ $transaction->category->name }}</td>
                            <td>
                                Rp {{ number_format($transaction->amount,0,',','.') }}
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="3" class="text-center">
                                Belum ada transaksi
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection
