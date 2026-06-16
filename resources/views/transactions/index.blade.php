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

    <div class="mb-4">

    <h2 class="table-section-title">
        <i class="bi bi-bar-chart-line-fill me-2"></i>
        Ringkasan Keuangan
    </h2>

    <p class="text-light opacity-75">
        Pantau kondisi keuangan Anda secara real-time.
    </p>

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
    📅 Ringkasan Berdasarkan Periode
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
    <!-- PAGINATION                                            -->
    <!-- ===================================================== -->

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

const categoryChart =
    document.getElementById('categoryChart');

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
</script>

@endpush

@endsection