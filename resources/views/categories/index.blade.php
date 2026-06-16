@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h1 class="page-title fw-bold mb-1">
            📁 Kategori Transaksi
        </h1>

        <p class="page-subtitle">
            Kelola semua kategori pemasukan dan pengeluaran
        </p>
    </div>

</div>

{{-- STAT KATEGORI TERBESAR --}}
<div class="row g-4 mb-4">

    <div class="col-md-6">

        <div class="stat-card danger-card">

            <div class="stat-title">
                Kategori Pengeluaran Terbesar
            </div>

            @if($topExpense)

                <div class="stat-value text-expense">
                    {{ $topExpense->name }}
                </div>

                <div class="mt-2 text-secondary">
                    Rp {{ number_format($topExpense->transactions_sum_amount ?? 0,0,',','.') }}
                </div>

            @else
                <div class="text-secondary">
                    Belum ada data
                </div>
            @endif

        </div>

    </div>

    <div class="col-md-6">

        <div class="stat-card success-card">

            <div class="stat-title">
                Kategori Pemasukan Terbesar
            </div>

            @if($topIncome)

                <div class="stat-value text-income">
                    {{ $topIncome->name }}
                </div>

                <div class="mt-2 text-secondary">
                    Rp {{ number_format($topIncome->transactions_sum_amount ?? 0,0,',','.') }}
                </div>

            @else
                <div class="text-secondary">
                    Belum ada data
                </div>
            @endif

        </div>

    </div>

</div>

{{-- TOTAL --}}
<div class="stat-card mb-4">

    <div class="stat-title">
        Total Seluruh Transaksi
    </div>

    <div class="stat-value">
        {{ $totalTransactions }}
    </div>

    <div class="text-secondary mt-2">
        Semua transaksi dari seluruh kategori
    </div>

</div>

{{-- TABLE --}}
<div class="card overflow-hidden">

    <div class="card-header">
        <h4 class="section-title">📊 Daftar Kategori</h4>
    </div>

    <div class="table-responsive">

        <table class="table align-middle mb-0">

            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Jenis</th>
                    <th>Jumlah Transaksi</th>
                    <th>Total Nominal</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

            @forelse($categories as $category)

                <tr>

                    <td class="transaction-title">
                        {{ $category->name }}
                    </td>

                    <td>
                        @if($category->type == 'income')
                            <span class="income-badge">⬆ Income</span>
                        @elseif($category->type == 'expense')
                            <span class="expense-badge">⬇ Expense</span>
                        @else
                            <span class="cat-type-badge other">Other</span>
                        @endif
                    </td>

                    <td>
                        {{ $category->transactions_count }}
                    </td>

                    <td>
                        Rp {{ number_format($category->transactions_sum_amount ?? 0,0,',','.') }}
                    </td>

                    <td>
                        <a href="{{ route('categories.show', $category) }}"
                           class="btn-act-edit">
                            👁 Lihat
                        </a>
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="5" class="text-center text-secondary py-4">
                        Belum ada kategori
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection