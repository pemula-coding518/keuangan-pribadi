@extends('layouts.app')

@section('content')

<div class="page-header">

<h1 class="page-title"><i class="ti ti-pencil"></i> Edit Transaksi</h1>

<p class="page-subtitle">
    Perbarui data transaksi Anda dengan mudah dan rapi.
</p>

</div>

<div class="card">

<div class="card-body">

    @if ($errors->any())

        <div class="alert alert-danger mb-4">

            <i class="ti ti-alert-circle"></i>

            <ul class="mb-0">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif

    <form
        action="{{ route('transactions.update', $transaction->id) }}"
        method="POST"
        class="transaction-form"
    
    >
        @csrf
        @method('PUT')

        <div class="form-grid">

            <div class="form-group">

                <label class="form-label">
                    Judul Transaksi
                </label>

                <input
                    type="text"
                    name="title"
                    class="form-control"
                    value="{{ old('title', $transaction->title) }}"
                >

            </div>

            <div class="form-group">

                <label class="form-label">
                    Jenis Transaksi
                </label>

                <select
                    name="type"
                    class="form-select"
                >

                    <option
                        value="pemasukan"
                        {{ old('type', $transaction->type) == 'pemasukan' ? 'selected' : '' }}
                    >
                        Pemasukan
                    </option>

                    <option
                        value="pengeluaran"
                        {{ old('type', $transaction->type) == 'pengeluaran' ? 'selected' : '' }}
                    >
                        Pengeluaran
                    </option>

                </select>

            </div>

            <div class="form-group">

                <label class="form-label">
                    Kategori
                </label>

                <select
                    name="category_id"
                    class="form-select"
                    required
                >

                    <option value="">
                        Pilih Kategori
                    </option>

                    @foreach($categories as $category)

                        <option
                            value="{{ $category->id }}"
                            {{ old('category_id', $transaction->category_id) == $category->id ? 'selected' : '' }}
                        >
                            {{ $category->name }}
                        </option>

                    @endforeach

                </select>

            </div>

            <div class="form-group">

                <label class="form-label">
                    Jumlah Uang
                </label>

                <input
                    type="number"
                    name="amount"
                    class="form-control"
                    value="{{ old('amount', $transaction->amount) }}"
                >

            </div>

            <div class="form-group">

                <label class="form-label">
                    Tanggal Transaksi
                </label>

                <input
                    type="date"
                    name="transaction_date"
                    class="form-control"
                    value="{{ old('transaction_date', \Carbon\Carbon::parse($transaction->transaction_date)->format('Y-m-d')) }}"
                >

            </div>

            <div class="form-group full-width">

                <label class="form-label">
                    Deskripsi
                </label>

                <textarea
                    name="description"
                    class="form-control"
                    rows="5"
                >{{ old('description', $transaction->description) }}</textarea>

            </div>

        </div>

        <div class="form-actions">

            <button
                type="submit"
                class="btn btn-primary"
            >
                <i class="ti ti-device-floppy"></i> Simpan Perubahan
            </button>

            <a
                href="{{ route('transactions.index') }}"
                class="btn btn-secondary"
            >
                <i class="ti ti-arrow-left"></i> Batal
            </a>

        </div>

    </form>

</div>


</div>

@endsection