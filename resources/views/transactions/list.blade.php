@extends('layouts.app')

@section('content')

<!-- ===================================================== -->
<!-- PAGE HEADER                                           -->
<!-- ===================================================== -->

<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

    <div>
        <h1 class="page-title"><i class="ti ti-receipt-2"></i> Money Tracker</h1>
        <p class="page-subtitle">Kelola seluruh transaksi keuangan Anda.</p>
    </div>

    <a href="{{ route('transactions.create') }}" class="btn btn-primary">
        <i class="ti ti-plus"></i> Tambah Data
    </a>

</div>

<!-- ===================================================== -->
<!-- SUCCESS ALERT                                         -->
<!-- ===================================================== -->

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4">
        <i class="ti ti-circle-check"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- ===================================================== -->
<!-- SEARCH (compact, tanpa card wrapper)                  -->
<!-- ===================================================== -->

<form method="GET" action="{{ route('transactions.list') }}" class="d-flex gap-2 mb-4">
    <input
        type="text"
        name="search"
        class="form-control"
        placeholder="Cari judul transaksi..."
        value="{{ request('search') }}"
    >
    <button type="submit" class="btn btn-primary" style="white-space:nowrap">
        <i class="ti ti-search"></i> Cari
    </button>
</form>

<!-- ===================================================== -->
<!-- TABLE CARD                                            -->
<!-- ===================================================== -->

<div class="card">

    <div class="card-header">
        <h5 class="section-title"><i class="ti ti-list-details"></i> Daftar Transaksi</h5>
        <p class="section-sub mb-0">Semua pemasukan dan pengeluaran Anda tercatat di sini.</p>
    </div>

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
                            {{ ($transactions->currentPage() - 1) * $transactions->perPage() + $loop->iteration }}
                        </td>

                        <td class="transaction-title">
                            {{ $item->title }}
                        </td>

                        <td class="category-col">
                            {{ $item->category->name ?? '-' }}
                        </td>

                        <td>
                            @if($item->type == 'pemasukan')
                                <span class="income-badge"><i class="ti ti-arrow-up-right"></i> Pemasukan</span>
                            @else
                                <span class="expense-badge"><i class="ti ti-arrow-down-right"></i> Pengeluaran</span>
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

                                <a href="{{ route('transactions.edit', $item->id) }}" class="btn-act-edit">
                                    <i class="ti ti-pencil"></i> Edit
                                </a>

                                <form action="{{ route('transactions.destroy', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="btn-act-delete"
                                        onclick="return confirm('Yakin ingin menghapus data ini?')"
                                    >
                                        <i class="ti ti-trash"></i> Hapus
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="ei"><i class="ti ti-inbox"></i></div>
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