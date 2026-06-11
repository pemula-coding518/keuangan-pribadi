@extends('layouts.app')

@section('content')

    <div class="container">

        <!-- Judul halaman -->
        <h2 class="mb-4">Tambah Transaksi</h2>

        <!-- Card Form -->
        <div class="card">

            <div class="card-body">

                <!-- Menampilkan error validasi -->
                @if ($errors->any())

                    <div class="alert alert-danger">

                        <ul class="mb-0">

                            @foreach ($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                @endif

                <!-- Form tambah transaksi -->
                <form action="{{ route('transactions.store') }}" method="POST">

                    @csrf

                    <!-- =========================
                         JUDUL TRANSAKSI
                    ========================== -->
                    <div class="mb-3">

                        <label class="form-label">
                            Judul Transaksi
                        </label>

                        <input type="text" name="title" class="form-control" placeholder="Masukkan judul transaksi"
                            value="{{ old('title') }}">

                    </div>

                    <!-- =========================
                         JENIS TRANSAKSI
                    ========================== -->
                    <div class="mb-3">

                        <label class="form-label">
                            Jenis Transaksi
                        </label>

                        <select name="type" class="form-control">

                            <option value="">
                                -- Pilih Jenis --
                            </option>

                            <option value="pemasukan" {{ old('type') == 'pemasukan' ? 'selected' : '' }}>
                                Pemasukan
                            </option>

                            <option value="pengeluaran" {{ old('type') == 'pengeluaran' ? 'selected' : '' }}>
                                Pengeluaran
                            </option>

                        </select>

                    </div>

                    <!-- =========================
                         KATEGORI
                    ========================== -->
                    <div class="mb-3">

                        <label class="form-label">
                            Kategori
                        </label>

                        <select name="category_id" class="form-control">

                            <option value="">
                                -- Pilih Kategori --
                            </option>

                            <!-- Loop data kategori -->
                            @foreach($categories as $category)

                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>

                                    {{ $category->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <!-- =========================
                         JUMLAH UANG
                    ========================== -->
                    <div class="mb-3">

                        <label class="form-label">
                            Jumlah Uang
                        </label>

                        <input type="number" name="amount" class="form-control" placeholder="Masukkan jumlah uang"
                            value="{{ old('amount') }}">

                    </div>

                    <!-- =========================
                         TANGGAL TRANSAKSI
                    ========================== -->
                    <div class="mb-3">

                        <label class="form-label">
                            Tanggal Transaksi
                        </label>

                        <input type="date" name="transaction_date" class="form-control"
                            value="{{ old('transaction_date') }}">

                    </div>

                    <!-- =========================
                         DESKRIPSI
                    ========================== -->
                    <div class="mb-3">

                        <label class="form-label">
                            Deskripsi
                        </label>

                        <textarea name="description" class="form-control" rows="4"
                            placeholder="Masukkan deskripsi transaksi">{{ old('description') }}</textarea>

                    </div>

                    <!-- =========================
                         BUTTON
                    ========================== -->
                    <button type="submit" class="btn btn-success">
                        Simpan
                    </button>

                    <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>

                </form>

            </div>

        </div>

    </div>

@endsection