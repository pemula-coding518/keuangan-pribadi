@extends('layouts.app')

@section('content')

    <!-- ===================================================== -->

    <!-- HALAMAN EDIT TRANSAKSI                                -->

    <!-- ===================================================== -->

    <div class="container">

        
        <div class="form-card">

    <h2 class="edit-title">
    ✏ Edit Transaksi
</h2>

<p class="edit-subtitle">
    Perbarui data transaksi Anda dengan mudah dan rapi.
</p>
    

        <!-- ===================================================== -->
        <!-- CARD FORM EDIT                                        -->
        <!-- ===================================================== -->

        <div class="card shadow-lg border-0 premium-form-card">

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

                        <label class="form-label">
    📌 Judul Transaksi
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

                        <label class="form-label">
    💳 Jenis Transaksi
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

                    <!-- ===================================== -->
                    <!-- Jumlah Uang                           -->
                    <!-- ===================================== -->
                    <div class="mb-3">

                       <label class="form-label">
    💰 Jumlah Uang
</label>

                        <input type="number" name="amount" class="form-control"
                            value="{{ old('amount', $transaction->amount) }}">

                    </div>

                    <!-- ===================================== -->
                    <!-- Tanggal                               -->
                    <!-- ===================================== -->
                    <div class="mb-3">

                        <label class="form-label">
    📅 Tanggal Transaksi
</label>

                        <input type="date" name="transaction_date" class="form-control"
                            value="{{ old('transaction_date', $transaction->transaction_date) }}">

                    </div>

                    <!-- ===================================== -->
                    <!-- Deskripsi                             -->
                    <!-- ===================================== -->
                    <div class="mb-4">

                        <label class="form-label">
    📝 Deskripsi
</label>
                        <textarea name="description" rows="4"
                            class="form-control">{{ old('description', $transaction->description) }}</textarea>

                    </div>

                    <!-- ===================================== -->
                    <!-- Tombol Aksi                           -->
                    <!-- ===================================== -->
                    <div class="d-flex gap-2">

                        <div class="d-flex gap-2">

  <div class="d-flex gap-2">

    <button type="submit" class="btn btn-warning btn-save">

        💾 Simpan Perubahan

    </button>


    <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
        ❌ Batal
    </a>

</div>
                

                </form>

            </div>

        </div>
        

    </div>

    <style>

.form-card{
    background: linear-gradient(
        145deg,
        #515f81
        #8995a7
    );
    border-radius:24px;
    padding:40px;
    box-shadow:0 20px 45px rgba(0,0,0,.08);
    border:1px solid rgba(0,0,0,.05);
}

.form-header{
border-bottom:1px solid rgba(0,0,0,.08);
padding-bottom:20px;
margin-bottom:30px;
}

.form-header h2{
font-size:2rem;
font-weight:800;
color:#111827;
margin-bottom:5px;
}

.form-header p{
color:#4b5563;
font-size:15px;
}

.form-label{
    font-weight: 700;
    font-size: 15px;
    color: #738dac;
    letter-spacing: .3px;
    margin-bottom: 8px;
}

.form-control,
.form-select{
background:#ffffff;

border:2px solid #1d62b1;

color:#111827;

font-weight:600;

border-radius:14px;

padding:12px 16px;

transition:.25s ease;
color: #2d3748;
font-weight: 500;

}

.form-control::placeholder{
color:#6b7280;
}

.form-control:focus,
.form-select:focus{
border-color:#f59e0b;

background:#ffffff;

box-shadow:
    0 0 0 .25rem rgba(245,158,11,.15);

transform:translateY(-1px);

}

textarea.form-control{
min-height:130px;
}

.btn-save{
background:linear-gradient(
135deg,
#f59e0b,
#fbbf24
);

border:none;

color:#fff;

font-weight:700;

padding:12px 28px;

border-radius:14px;

}

.btn-save:hover{
transform:translateY(-2px);


box-shadow:
    0 10px 20px rgba(245,158,11,.25);

}

.btn-back{
border-radius:14px;

font-weight:700;

padding:12px 24px;

}

small.text-danger{
font-weight:600;
}

.premium-form-card{
background: linear-gradient(
135deg,
#2c3344 0%,
#374151 50%,
#475569 100%
) !important;

```
border-radius: 20px;
overflow: hidden;
```

}

.premium-form-card .card-header{
background: rgba(255,255,255,0.08) !important;
border-bottom: 1px solid rgba(255,255,255,0.1);
color: #f8fafc !important;
}

.premium-form-card .card-body{
background: transparent !important;
}

.premium-form-card .form-label{
color: #e5e7eb !important;
font-weight: 700;
}

.premium-form-card .form-control,
.premium-form-card .form-select,
.premium-form-card textarea{
background: rgba(255,255,255,0.08) !important;
border: 1px solid rgba(255,255,255,0.15) !important;
color: #ffffff !important;
}

.premium-form-card .form-control:focus,
.premium-form-card .form-select:focus,
.premium-form-card textarea:focus{
background: rgba(255,255,255,0.12) !important;
border-color: #ffc107 !important;
box-shadow: 0 0 0 .25rem rgba(255,193,7,.15);
}

.premium-form-card .form-control::placeholder{
color: #cbd5e1;
}

.form-select {
    background-color: rgba(255,255,255,0.08) !important;
    color: white !important;
    border: 1px solid rgba(255,255,255,0.15) !important;
}

.form-select option {
    background-color: #1e293b !important;
    color: #ffffff !important;
}

.edit-title{
    font-weight: 800;
    background: linear-gradient(135deg,#ffffff,#c7d2fe);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: .3rem;
}

.edit-subtitle{
    color: rgba(255,255,255,.75);
    font-size: .95rem;
}
</style>


@endsection