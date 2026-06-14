@extends('layouts.app')

@section('content')
<div class="mb-5">

    <h1 class="page-title fw-bold mb-2"
    style="
        color:#ffffff;
        text-shadow:0 2px 10px rgba(0,0,0,.3);
    ">
    Dashboard Keuangan
</h1>

<p style="
    color:rgba(255,255,255,.85);
    font-size:1.05rem;
    margin-bottom:0;
">
    Kelola pemasukan dan pengeluaran dengan lebih cerdas.
</p>

</div>

    <!-- ===================================================== -->
    <!-- HEADER HALAMAN                                        -->
    <!-- ===================================================== -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="table-section-title">

    <i class="bi bi-bar-chart-line-fill me-2"></i>
    Data Keuangan

</h2>

        <!-- Tombol tambah transaksi -->
        <a href="{{ route('transactions.create') }}"
   class="btn add-btn">
   + Tambah Data
</a>
    </div>

    <!-- ===================================================== -->
    <!-- DASHBOARD STATISTIK                                   -->
    <!-- ===================================================== -->

    <div class="row g-4 mb-5">

    <div class="col-md-4">

        <div class="stat-card">

            <div class="stat-title">
                Total Saldo
            </div>

            <div class="stat-value text-warning">
                Rp {{ number_format($balance,0,',','.') }}
            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="stat-card">

            <div class="stat-title">
                Total Pemasukan
            </div>

            <div class="stat-value text-income">
                Rp {{ number_format($totalIncome,0,',','.') }}
            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="stat-card">

            <div class="stat-title">
                Total Pengeluaran
            </div>

            <div class="stat-value text-expense">
                Rp {{ number_format($totalExpense,0,',','.') }}
            </div>

        </div>

    </div>

</div>

        

    <!-- ===================================================== -->
    <!-- DASHBOARD RINGKASAN KEUANGAN                          -->
    <!-- ===================================================== -->

    <h4 class="mb-3">

        📈 Ringkasan Keuangan

    </h4>

    <div class="row g-3 mb-4">

        <!-- ================================================= -->
        <!-- LAPORAN MINGGUAN                                  -->
        <!-- ================================================= -->

        <div class="col-md-4">

            <!--
                Ketika card diklik:
                /report/weekly
            -->
            <a href="{{ route('transactions.report', 'weekly') }}" class="text-decoration-none text-dark">

               <div class="card report-card">
    <div class="card-body report-content">

                        <h5 class="stats-label">

                            📅 Minggu Ini

                        </h5>

                        <hr>

                        <!-- Total pemasukan minggu ini -->
                        <p class="stats-value">

                            Pemasukan :
                            Rp {{ number_format($weeklyIncome, 0, ',', '.') }}

                        </p>

                        <!-- Total pengeluaran minggu ini -->
                        <p class="stats-value-loss">

                            Pengeluaran :
                            Rp {{ number_format($weeklyExpense, 0, ',', '.') }}

                        </p>

                        <!-- Petunjuk klik -->
                        <small class="text-primary">

                            Lihat Detail Laporan →

                        </small>

</div>

                </div>

            </a>

        </div>

        <!-- ================================================= -->
        <!-- LAPORAN BULANAN                                   -->
        <!-- ================================================= -->

        <div class="col-md-4">

            <a href="{{ route('transactions.report', 'monthly') }}" class="text-decoration-none text-dark">

                <div class="card report-card">
    <div class="card-body report-content">

                    

                        <h5 class="stats-label">

                            📆 Bulan Ini

                        </h5>

                        <hr>

                        <p class="stats-value">

                            Pemasukan :
                            Rp {{ number_format($monthlyIncome, 0, ',', '.') }}

                        </p>

                        <p class="stats-value-loss">

                            Pengeluaran :
                            Rp {{ number_format($monthlyExpense, 0, ',', '.') }}

                        </p>

                        <small class="text-primary">

                            Lihat Detail Laporan ->

                        </small>

</div>

                </div>

            </a>

        </div>

        <!-- ================================================= -->
        <!-- LAPORAN TAHUNAN                                   -->
        <!-- ================================================= -->

        <div class="col-md-4">

            <a href="{{ route('transactions.report', 'yearly') }}" class="text-decoration-none text-dark">

               <div class="card report-card">
    <div class="card-body report-content">

                    

                        <h5 class="stats-label">

                            🗓️ Tahun Ini

                        </h5>

                        <hr>

                        <p class="stats-value">

                            Pemasukan :
                            Rp {{ number_format($yearlyIncome, 0, ',', '.') }}

                        </p>

                        <p class="stats-value-loss">

                            Pengeluaran :
                            Rp {{ number_format($yearlyExpense, 0, ',', '.') }}

                        </p>

                        <small class="text-primary">

                            Lihat Detail Laporan →

                        </small>

</div>

                </div>

            </a>

        </div>

    </div>

    <!-- ===================================================== -->
    <!-- ALERT SUKSES                                          -->
    <!-- ===================================================== -->

    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

        </div>

    @endif

<div class="row mt-4">

    <div class="col-lg-8 mb-4">

        <div class="dashboard-card">

            <div class="card-body">

                <h5 class="section-title mb-4">
                    📈 Tren Keuangan
                </h5>

                <canvas id="financeChart"></canvas>

            </div>

        </div>

    </div>

    <div class="col-lg-4 mb-4">

        <div class="dashboard-card">

            <div class="card-body">

                <h5 class="section-title mb-4">
                    📊 Pengeluaran per Kategori
                </h5>

                <canvas id="categoryChart"></canvas>

            </div>

        </div>

    </div>

</div>


    <!-- ===================================================== -->
    <!-- TABEL TRANSAKSI                                       -->
    <!-- ===================================================== -->

    <div class="card overflow-hidden">

    <div class="card-header border-0 py-4">

        <h4 class="table-section-title mb-0">

            <i class="bi bi-receipt-cutoff me-2"></i>
            Daftar Transaksi

        </h4>

    </div>

    <div class="table-responsive">
                <table class="table table-dark-luxury align-middle mb-0">

                    <thead>

                        <tr>

                            <th>No</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Jenis</th>
                            <th>Jumlah</th>
                            <th>Tanggal</th>
                            <th width="18%">Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($transactions as $item)

                                        <tr>

                                            <!-- Nomor -->
                                            <td>

                                                {{
                            ($transactions->currentPage() - 1)
                            * $transactions->perPage()
                            + $loop->iteration
                                                                                                                                    }}

                                            </td>

                                            <!-- Judul -->
                                            <td class="transaction-title">

    {{ $item->title }}

</td>
                                            <!-- Kategori -->
                                            <<td class="category-column">
    {{ $item->category->name ?? '-' }}
</td>
                                            <!-- Jenis -->
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

                                            <!-- Jumlah -->
                                            <td>

                                                Rp {{ number_format($item->amount, 0, ',', '.') }}

                                            </td>

                                            <!-- Tanggal -->
                                            <td>

                                                {{ \Carbon\Carbon::parse($item->transaction_date)->format('d-m-Y') }}

                                            </td>

                                            <td>

    <div class="d-flex gap-2">

        <a href="{{ route('transactions.edit', $item->id) }}"
           class="btn-action-edit">

            ✏ Edit

        </a>

        <form action="{{ route('transactions.destroy', $item->id) }}"
              method="POST">

            @csrf
            @method('DELETE')

            <button
                type="submit"
                class="btn-action-delete"
                onclick="return confirm('Yakin ingin menghapus data ini?')">

                🗑 Hapus

            </button>

        </form>

    </div>

</td>

                        @empty

                            <tr>

                               <td colspan="7">

    <div class="empty-state text-center">

        <div class="empty-icon">
            📂
        </div>

        <h4 class="mt-3">
            Belum Ada Transaksi
        </h4>

        <p class="text-secondary mb-0">
            Silakan tambahkan transaksi pertama Anda.
        </p>

    </div>

</td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <!-- ===================================================== -->
    <!-- PAGINATION                                            -->
    <!-- ===================================================== -->

    <div class="mt-4">

        {{ $transactions->links() }}

    </div>

    <style>

.page-title{
    font-size: 2rem;
    font-weight: 700;
    color: #212529;
}

.form-card{
    background: #fff;
    border-radius: 20px;
    padding: 35px;
    border: none;
    box-shadow: 0 15px 35px rgba(0,0,0,.08);
}

.form-label{
    font-weight: 600;
    color: #212529;
    margin-bottom: 8px;
}

.form-control,
.form-select{
    border-radius: 12px;
    border: 1px solid #dfe3e8;
    padding: 12px 15px;
    transition: all .3s ease;
    background: #fafbfc;
}

.form-control:focus,
.form-select:focus{
    border-color: #0d6efd;
    box-shadow: 0 0 0 .25rem rgba(13,110,253,.15);
    background: #fff;
}

.form-control::placeholder{
    color: #9ca3af;
}

.btn-save{
    border-radius: 12px;
    padding: 12px 24px;
    font-weight: 600;
}

.btn-back{
    border-radius: 12px;
    padding: 12px 24px;
    font-weight: 600;
}

.form-header{
    margin-bottom: 30px;
}

.form-header h2{
    font-weight: 700;
    margin-bottom: 5px;
}

.form-header p{
    color: #6c757d;
    margin-bottom: 0;
}

.add-btn{
    background: linear-gradient(
        135deg,
        #4f46e5,
        #7c3aed
    );
    color:white !important;
    border:none;
    font-weight:600;
    padding:12px 22px;
    border-radius:12px;
    transition:all .3s ease;
    box-shadow:0 8px 20px rgba(79,70,229,.35);
}

.add-btn:hover{
    color:white !important;
    transform:translateY(-2px);
    box-shadow:0 12px 25px rgba(79,70,229,.45);
}

.add-btn:focus{
    color:white !important;
}

.stats-label{
    color:rgba(255,255,255,.85);
    font-size:.95rem;
    font-weight:600;
    letter-spacing:.5px;
}

.stats-value{
    color:rgba(5, 247, 9, 0.85);
    font-weight:600;
}
.stats-value-loss{
    color:red;
    font-weight:600;
}
.report-card{
    border-radius:16px;
}

.report-content{
    padding:30px;
    max-width:90%;
    margin:0 auto;
}
</style>

@push('scripts')

<script>
    const months = @json($chartData->pluck('month'));
const incomes = @json($chartData->pluck('pemasukan'));
const expenses = @json($chartData->pluck('pengeluaran'));

document.addEventListener('DOMContentLoaded', function () {

    const financeChart =
        document.getElementById('financeChart');

    if (financeChart) {

        new Chart(financeChart, {
    type: 'line',
    data: {
        labels: months,
        datasets: [
            {
                label: 'Pemasukan',
                data: incomes,
                tension: 0.4
            },
            {
                label: 'Pengeluaran',
                data: expenses,
                tension: 0.4
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

   const categoryLabels = @json($expenseByCategory->pluck('category'));
const categoryTotals = @json($expenseByCategory->pluck('total'));

new Chart(categoryChart, {
    type: 'doughnut',
    data: {
        labels: categoryLabels,
        datasets: [{
            data: categoryTotals
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

    }

});
const categoryLabels =
    @json($expenseByCategory->pluck('category'));

const categoryTotals =
    @json($expenseByCategory->pluck('total'));

</script>

@endpush

@endsection