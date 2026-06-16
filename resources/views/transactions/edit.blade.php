@extends('layouts.app')

@section('content')

<!-- ===================================================== -->
<!-- PAGE HEADER                                           -->
<!-- ===================================================== -->

<div class="page-header">

    <h1 class="page-title">
        ✏ Edit Transaksi
    </h1>

    <p class="page-subtitle">
        Perbarui data transaksi Anda dengan mudah dan rapi.
    </p>

</div>

<!-- ===================================================== -->
<!-- FORM CARD                                             -->
<!-- ===================================================== -->

<div class="card">

    <div class="card-body">

        <!-- ERROR -->
        @if ($errors->any())

            <div class="alert alert-danger">

                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>

        @endif

        <!-- FORM -->
        <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">

            @csrf
            @method('PUT')

            <!-- TITLE -->
            <div class="mb-3">

                <label class="form-label">Judul Transaksi</label>

                <input type="text"
                       name="title"
                       class="form-control"
                       value="{{ old('title', $transaction->title) }}">

            </div>

            <!-- TYPE -->
            <div class="mb-3">

                <label class="form-label">Jenis Transaksi</label>

                <select name="type" class="form-select">

                    <option value="pemasukan" {{ $transaction->type == 'pemasukan' ? 'selected' : '' }}>
                        Pemasukan
                    </option>

                    <option value="pengeluaran" {{ $transaction->type == 'pengeluaran' ? 'selected' : '' }}>
                        Pengeluaran
                    </option>

                </select>

            </div>

            <!-- CATEGORY -->
            <div class="mb-3">

                <label class="form-label">Kategori</label>

                <select name="category_id" class="form-select" required>

                    <option value="">Pilih Kategori</option>

                    @foreach($categories as $category)

                        <option value="{{ $category->id }}"
                            {{ old('category_id', $transaction->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>

                    @endforeach

                </select>

            </div>

            <!-- AMOUNT -->
            <div class="mb-3">

                <label class="form-label">Jumlah Uang</label>

                <input type="number"
                       name="amount"
                       class="form-control"
                       value="{{ old('amount', $transaction->amount) }}">

            </div>

            <!-- DATE -->
            <div class="mb-3">

                <label class="form-label">Tanggal Transaksi</label>

                <input type="date"
                       name="transaction_date"
                       class="form-control"
                       value="{{ old('transaction_date', $transaction->transaction_date) }}">

            </div>

            <!-- DESCRIPTION -->
            <div class="mb-3">

                <label class="form-label">Deskripsi</label>

                <textarea name="description"
                          class="form-control"
                          rows="4">{{ old('description', $transaction->description) }}</textarea>

            </div>

            <!-- BUTTONS -->
            <div class="d-flex gap-2 mt-4">

                <button type="submit" class="btn btn-primary">
                    💾 Simpan Perubahan
                </button>

                <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
                    ← Batal
                </a>

            </div>

        </form>

    </div>

</div>

@endsection