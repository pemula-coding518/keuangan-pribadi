@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h1 class="page-title fw-bold text-white">
            💰 Money Tracker
        </h1>

        <p class="text-light opacity-75 mb-0">
            Kelola seluruh transaksi keuangan Anda.
        </p>

    </div>

    <a href="{{ route('transactions.create') }}"
       class="btn add-btn">

        + Tambah Data

    </a>

</div>

@if(session('success'))

<div class="alert alert-success alert-dismissible fade show">

    {{ session('success') }}

    <button type="button"
            class="btn-close"
            data-bs-dismiss="alert"></button>

</div>

@endif

<div class="card mb-4">

    <div class="card-body">

        <form method="GET"
              action="{{ route('transactions.list') }}">

            <div class="row g-2">

                <div class="col-md-10">

                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Cari judul transaksi..."
                        value="{{ request('search') }}">

                </div>

                <div class="col-md-2">

                    <button
                        type="submit"
                        class="btn btn-primary w-100">

                        🔍 Cari

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

<div class="card overflow-hidden">

    <div class="card-header border-0 py-4">

        <h4 class="table-section-title mb-1">

            <i class="bi bi-receipt-cutoff me-2"></i>
            Daftar Transaksi

        </h4>

        <small class="text-secondary">

            Semua pemasukan dan pengeluaran Anda tercatat di sini.

        </small>

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
                    <th width="18%">Aksi</th>

                </tr>

            </thead>

            <tbody>

                @forelse($transactions as $item)

                <tr>

                    <td>

                        {{
                            ($transactions->currentPage() - 1)
                            * $transactions->perPage()
                            + $loop->iteration
                        }}

                    </td>

                    <td class="transaction-title">

                        {{ $item->title }}

                    </td>

                    <td class="category-column">

                        {{ $item->category->name ?? '-' }}

                    </td>

                    <td>

                        @if($item->type == 'pemasukan')

                            <span class="income-badge">

                                ⬆ Pemasukan

                            </span>

                        @else

                            <span class="expense-badge">

                                ⬇ Pengeluaran

                            </span>

                        @endif

                    </td>

                    <td>

                        Rp {{ number_format($item->amount, 0, ',', '.') }}

                    </td>

                    <td>

                        {{ \Carbon\Carbon::parse($item->transaction_date)->format('d-m-Y') }}

                    </td>

                    <td>

                        <div class="d-flex flex-wrap gap-2">

                            <a href="{{ route('transactions.edit', $item->id) }}"
                               class="btn-action-edit">

                                ✏ Edit

                            </a>

                            <form action="{{ route('transactions.destroy', $item->id) }}"
                                  method="POST">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn-action-delete"
                                    onclick="return confirm('Yakin ingin menghapus data ini?')">

                                    🗑 Hapus

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="7">

                        <div class="empty-state text-center py-5">

                            <div class="empty-icon fs-1">
                                📂
                            </div>

                            <h4 class="mt-3">

                                Belum Ada Transaksi

                            </h4>

                            <p class="text-secondary mb-0">

                                Silakan tambahkan transaksi pertama Anda.

                            </p>

                        </div>

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