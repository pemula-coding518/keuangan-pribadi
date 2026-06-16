@extends('layouts.app')

@section('content')

<div class="page-header">
    <h1 class="page-title">Tambah Catatan</h1>
    <p class="page-subtitle">
        Catat pemasukan dan pengeluaran dengan mudah dan rapi.
    </p>
</div>

<div class="card">
    <div class="card-body">


    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('transactions.store') }}"
        method="POST"
        class="transaction-form"
    >
        @csrf

        <div class="form-grid">

            <div class="form-group">
                <label class="form-label">Judul Transaksi</label>
                <input
                    type="text"
                    name="title"
                    class="form-control"
                    placeholder="Masukkan judul transaksi"
                    value="{{ old('title') }}"
                >
            </div>

            <div class="form-group">
                <label class="form-label">Jenis Transaksi</label>

                <select name="type" class="form-select">
                    <option value="">-- Pilih Jenis --</option>

                    <option
                        value="pemasukan"
                        {{ old('type') == 'pemasukan' ? 'selected' : '' }}
                    >
                        Pemasukan
                    </option>

                    <option
                        value="pengeluaran"
                        {{ old('type') == 'pengeluaran' ? 'selected' : '' }}
                    >
                        Pengeluaran
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Kategori</label>

                <select
                    name="category_id"
                    class="form-select"
                    required
                >
                    <option value="">Pilih Kategori</option>

                    @foreach($categories as $category)
                        <option
                            value="{{ $category->id }}"
                            {{ old('category_id') == $category->id ? 'selected' : '' }}
                        >
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Jumlah Uang</label>

                <input
                    type="number"
                    name="amount"
                    class="form-control"
                    placeholder="Masukkan jumlah uang"
                    value="{{ old('amount') }}"
                >
            </div>

            <div class="form-group">
                <label class="form-label">Tanggal Transaksi</label>

                <input
                    type="date"
                    name="transaction_date"
                    class="form-control"
                    value="{{ old('transaction_date') }}"
                >
            </div>

            <div class="form-group full-width">
                <label class="form-label">Deskripsi</label>

                <textarea
                    name="description"
                    class="form-control"
                    rows="5"
                    placeholder="Masukkan deskripsi transaksi"
                >{{ old('description') }}</textarea>
            </div>

        </div>

        <div class="form-actions">

            <button
                type="submit"
                class="btn btn-primary"
            >
                💾 Simpan Transaksi
            </button>

            <a
                href="{{ route('transactions.index') }}"
                class="btn btn-secondary"
            >
                ← Kembali
            </a>

        </div>

    </form>

</div>


</div>

@endsection
