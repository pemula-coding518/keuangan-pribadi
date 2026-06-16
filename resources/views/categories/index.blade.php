@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Daftar Kategori</h2>
     <div class="row mb-4">

    <div class="col-md-6">
        <div class="card border-danger">
            <div class="card-body">

                <h6>Kategori Pengeluaran Terbesar</h6>

                @if($topExpense)

                    <h4>{{ $topExpense->name }}</h4>

                    <strong>
                        Rp {{ number_format($topExpense->transactions_sum_amount ?? 0,0,',','.') }}
                    </strong>

                @else

                    <p>Belum ada data</p>

                @endif

            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-success">
            <div class="card-body">

                <h6>Kategori Pemasukan Terbesar</h6>

                @if($topIncome)

                    <h4>{{ $topIncome->name }}</h4>

                    <strong>
                        Rp {{ number_format($topIncome->transactions_sum_amount ?? 0,0,',','.') }}
                    </strong>

                @else

                    <p>Belum ada data</p>

                @endif

            </div>
        </div>
    </div>

</div>
    <div class="card mb-3">
    <div class="card-body">
       <h5>Total Seluruh Transaksi</h5>

<h3>{{ $totalTransactions }}</h3>

<small>
    Semua transaksi dari seluruh kategori
</small>
    </div>
</div>

    <table class="table table-striped table-hover">
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
    <td>{{ $category->name }}</td>

<td>{{ ucfirst($category->type) }}</td>

<td>{{ $category->transactions_count }}</td>

<td>
    Rp {{ number_format($category->transactions_sum_amount ?? 0,0,',','.') }}
</td>

<td>

    <a
        href="{{ route('categories.show', $category) }}"
        class="btn btn-primary btn-sm">

        Lihat

    </a>

</td>
</tr>

@empty

<tr>
    <td colspan="5">
        Belum ada kategori
    </td>
</tr>

@endforelse

        </tbody>

    </table>

</div>

@endsection