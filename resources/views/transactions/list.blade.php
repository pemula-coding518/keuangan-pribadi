@extends('layouts.app')

@section('content')

<!-- ===================================================== -->
<!-- PAGE HEADER                                           -->
<!-- ===================================================== -->

<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-3">

    <div>

        <h1 class="page-title">💰 Money Tracker</h1>

        <p class="page-subtitle">
            Kelola seluruh transaksi keuangan Anda.
        </p>

    </div>

    <a href="{{ route('transactions.create') }}" class="add-btn">
        + Tambah Data
    </a>

</div>

<!-- ===================================================== -->
<!-- SUCCESS ALERT                                         -->
<!-- ===================================================== -->

@if(session('success'))

    <div class="alert alert-success alert-dismissible fade show">

        {{ session('success') }}

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

    </div>

@endif

<!-- ===================================================== -->
<!-- SEARCH BOX                                            -->
<!-- ===================================================== -->

<div class="card mb-4">

    <div class="card-body">

        <form method="GET" action="{{ route('transactions.list') }}">

            <div class="row g-2">

                <div class="col-md-10">

                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Cari judul transaksi..."
                        value="{{ request('search') }}"
                    >

                </div>

                <div class="col-md-2">

                    <button type="submit" class="btn btn-primary w-100">
                        🔍 Cari
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

<!-- ===================================================== -->
<!-- TABLE CARD                                            -->
<!-- ===================================================== -->

<div class="card">

    <!-- HEADER -->
    <div class="card-header">

        <h5 class="section-title">
            📋 Daftar Transaksi
        </h5>

        <p class="section-sub mb-0">
            Semua pemasukan dan pengeluaran Anda tercatat di sini.
        </p>

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
                    <th>Aksi</th>

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

                        <td class="category-col">
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

                            <div class="d-flex gap-2 flex-wrap">

                                <a href="{{ route('transactions.edit', $item->id) }}"
                                   class="btn-act-edit">
                                    ✏ Edit
                                </a>

                                <form action="{{ route('transactions.destroy', $item->id) }}"
                                      method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn-act-delete"
                                        onclick="return confirm('Yakin ingin menghapus data ini?')"
                                    >
                                        🗑 Hapus
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7">

                            <div class="empty-state">

                                <div class="ei">📂</div>

                                <h5>Belum Ada Transaksi</h5>

                                <p>Silakan tambahkan transaksi pertama Anda.</p>

                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<!-- ===================================================== -->
<!-- PAGINATION                                            -->
<!-- ===================================================== -->

<div class="mt-4">
    {{ $transactions->links() }}
</div>

@endsection