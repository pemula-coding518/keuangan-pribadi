@extends('layouts.app')

@section('content')

<div class="container">

    <h2>
        Kategori: {{ $category->name }}
    </h2>

<p>
    Jenis:
    <strong>
        {{ ucfirst($category->type) }}
    </strong>
</p>

<a href="{{ route('categories.index') }}"
   class="btn btn-secondary mb-3">
    ← Kembali ke Daftar Kategori
</a>

    <div class="row mb-4">

    <div class="col-md-6">

        <div class="card">
            <div class="card-body">

                <h6>Total Transaksi</h6>

                <h3>
                    {{ $totalTransactions }}
                </h3>

            </div>
        </div>

    </div>

    <div class="col-md-6">

        <div class="card">
            <div class="card-body">

                <h6>Total Nominal</h6>

                <h3>
                    Rp {{ number_format($totalAmount,0,',','.') }}
                </h3>

            </div>
        </div>

    </div>

</div>

    <table class="table">

        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Judul</th>
                <th>Jumlah</th>
            </tr>
        </thead>

        <tbody>

        @forelse($transactions as $transaction)

            <tr>

                <td>
                    {{ $transaction->transaction_date }}
                </td>

                <td>
                    {{ $transaction->title }}
                </td>

                <td>
                    Rp {{ number_format($transaction->amount,0,',','.') }}
                </td>

            </tr>

        @empty

            <tr>
                <td colspan="3">
                    Tidak ada transaksi
                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

    {{ $transactions->links() }}

</div>

@endsection