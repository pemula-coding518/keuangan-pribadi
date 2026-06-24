@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h1 class="page-title">
            <i class="ti ti-tag"></i> {{ $category->name }}
        </h1>

        <p class="page-subtitle">
            Detail kategori transaksi
        </p>
    </div>

    <a href="{{ route('categories.index') }}"
       class="btn btn-secondary">
        <i class="ti ti-arrow-left"></i> Kembali
    </a>

</div>

{{-- INFO CARD --}}
<div class="row g-4 mb-4">

    <div class="col-md-6">

        <div class="stat-card">

            <div class="stat-title">
                <i class="ti ti-list-details"></i> Total Transaksi
            </div>

            <div class="stat-value">
                {{ $totalTransactions }}
            </div>

        </div>

    </div>

    <div class="col-md-6">

        <div class="stat-card">

            <div class="stat-title">
                <i class="ti ti-wallet"></i> Total Nominal
            </div>

            <div class="stat-value">
                Rp {{ number_format($totalAmount,0,',','.') }}
            </div>

        </div>

    </div>

</div>

{{-- TABLE --}}
<div class="card overflow-hidden">

    <div class="card-header">
        <h4 class="section-title"><i class="ti ti-list-details"></i> Transaksi dalam Kategori</h4>
    </div>

    <div class="table-responsive">

        <table class="table align-middle mb-0">

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
                        {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d-m-Y') }}
                    </td>

                    <td class="transaction-title">
                        {{ $transaction->title }}
                    </td>

                    <td>
                        Rp {{ number_format($transaction->amount,0,',','.') }}
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="3" class="text-center text-secondary py-4">
                        Tidak ada transaksi
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

<div class="mt-4">
    {{ $transactions->links() }}
</div>

@endsection