@extends('layouts.app')

@section('content')

    <div class="container">

        <!-- Judul halaman -->
       <div class="mb-4">
    <h2 class="edit-title">
        ➕ Tambah Transaksi
    </h2>

    <p class="edit-subtitle">
        Catat pemasukan dan pengeluaran dengan mudah dan rapi.
    </p>
</div>

        <!-- Card Form -->
        <div class="card glass-card border-0 shadow-lg">
    <div class="card-body p-4">

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

                       <select name="type" class="form-select">

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

    <select
        name="category_id"
        class="form-select"
        required>

        <option value="">
            Pilih Kategori
        </option>

        @foreach($categories as $category)

            <option
                value="{{ $category->id }}"
                {{ old('category_id') == $category->id ? 'selected' : '' }}>

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
                    <button type="submit" class="btn btn-save">
    💾 Simpan Transaksi
</button>

<a href="{{ route('transactions.index') }}" class="btn btn-back">
    ← Kembali
</a>

                </form>

            </div>

        </div>

    </div>

    <style>
.glass-card{
    background: linear-gradient(
        135deg,
        rgba(79,70,229,.95),
        rgba(124,58,237,.92)
    ) !important;

    border-radius: 24px;
    backdrop-filter: blur(12px);
    color: white;
}

.edit-title{
    font-weight: 800;
    background: linear-gradient(
        135deg,
        #ffffff,
        #dbeafe
    );

    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.edit-subtitle{
    color: rgba(255,255,255,.8);
}

.glass-card .form-label{
    color: white;
    font-weight: 600;
}

.glass-card .form-control,
.glass-card .form-select{
    background: rgba(255,255,255,.08);
    border: 1px solid rgba(255,255,255,.15);
    color: white;
}

.glass-card .form-control:focus,
.glass-card .form-select:focus{
    background: rgba(255,255,255,.12);
    color: white;
    border-color: rgba(255,255,255,.4);
    box-shadow: 0 0 0 .2rem rgba(255,255,255,.15);
}

.glass-card .form-control::placeholder{
    color: rgba(255,255,255,.6);
}

.glass-card select option{
    background: #1e293b;
    color: white;
}

.btn-save{
    background: linear-gradient(
        135deg,
        #22c55e,
        #16a34a
    );
    border: none;
    padding: 10px 22px;
    font-weight: 600;
}

.btn-save:hover{
    transform: translateY(-2px);
}

.btn-back{
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.15);
    color: white;
    padding: 10px 22px;
}

.btn-back:hover{
    background: rgba(255,255,255,.2);
    color: white;
}
</style>

@endsection