@extends('layouts.app')

@section('content')

    <!-- ===================================================== -->

    <!-- HALAMAN EDIT TRANSAKSI                                -->

    <!-- ===================================================== -->

    <div class="container">

        ```
        <!-- Judul Halaman -->
        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2 class="fw-bold text-warning">

                ✏ Edit Transaksi

            </h2>

            <!-- Tombol kembali ke halaman utama -->
            <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary">

                ← Kembali

            </a>

        </div>

        <!-- ===================================================== -->
        <!-- CARD FORM EDIT                                        -->
        <!-- ===================================================== -->

        <div class="card shadow border-0">

            <div class="card-header bg-warning text-dark">

                <h5 class="mb-0">

                    Form Edit Transaksi

                </h5>

            </div>

            <div class="card-body">

                <!-- Form Update -->
                <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <!-- ===================================== -->
                    <!-- Judul Transaksi                       -->
                    <!-- ===================================== -->
                    <div class="mb-3">

                        <label class="form-label fw-semibold">

                            Judul Transaksi

                        </label>

                        <input type="text" name="title" class="form-control"
                            value="{{ old('title', $transaction->title) }}">

                        @error('title')

                            <small class="text-danger">

                                {{ $message }}

                            </small>

                        @enderror

                    </div>

                    <!-- ===================================== -->
                    <!-- Jenis Transaksi                       -->
                    <!-- ===================================== -->
                    <div class="mb-3">

                        <label class="form-label fw-semibold">

                            Jenis Transaksi

                        </label>

                        <select name="type" class="form-select">

                            <option value="pemasukan" {{ $transaction->type == 'pemasukan' ? 'selected' : '' }}>

                                Pemasukan

                            </option>

                            <option value="pengeluaran" {{ $transaction->type == 'pengeluaran' ? 'selected' : '' }}>

                                Pengeluaran

                            </option>

                        </select>

                    </div>

                    <!-- ===================================== -->
                    <!-- Kategori                              -->
                    <!-- ===================================== -->
                    <div class="mb-3">

                        <label class="form-label fw-semibold">

                            Kategori

                        </label>

                        <select name="category_id" class="form-select">

                            @foreach($categories as $category)

                                <option value="{{ $category->id }}" {{ $transaction->category_id == $category->id ? 'selected' : '' }}>

                                    {{ $category->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <!-- ===================================== -->
                    <!-- Jumlah Uang                           -->
                    <!-- ===================================== -->
                    <div class="mb-3">

                        <label class="form-label fw-semibold">

                            Jumlah Uang

                        </label>

                        <input type="number" name="amount" class="form-control"
                            value="{{ old('amount', $transaction->amount) }}">

                    </div>

                    <!-- ===================================== -->
                    <!-- Tanggal                               -->
                    <!-- ===================================== -->
                    <div class="mb-3">

                        <label class="form-label fw-semibold">

                            Tanggal Transaksi

                        </label>

                        <input type="date" name="transaction_date" class="form-control"
                            value="{{ old('transaction_date', $transaction->transaction_date) }}">

                    </div>

                    <!-- ===================================== -->
                    <!-- Deskripsi                             -->
                    <!-- ===================================== -->
                    <div class="mb-4">

                        <label class="form-label fw-semibold">

                            Deskripsi

                        </label>

                        <textarea name="description" rows="4"
                            class="form-control">{{ old('description', $transaction->description) }}</textarea>

                    </div>

                    <!-- ===================================== -->
                    <!-- Tombol Aksi                           -->
                    <!-- ===================================== -->
                    <div class="d-flex gap-2">

                        <button type="submit" class="btn btn-warning">

                            💾 Update Transaksi

                        </button>

                        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">

                            Batal

                        </a>

                    </div>

                </form>

            </div>

        </div>
        ```

    </div>

@endsection