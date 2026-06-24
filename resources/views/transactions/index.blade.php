@extends('layouts.app')

@section('content')

<!-- ===================================================== -->
<!-- PAGE HEADER                                           -->
<!-- ===================================================== -->

<div class="page-header">

    <h1 class="page-title">Dashboard Keuangan</h1>

    <p class="page-subtitle">
        Kelola pemasukan dan pengeluaran dengan lebih cerdas.
    </p>

</div>

<!-- ===================================================== -->
<!-- BALANCE HERO                                          -->
<!-- ===================================================== -->

<div class="balance-hero">

    <div class="balance-hero-top">

        <div>
            <div class="balance-hero-label">
                <i class="ti ti-wallet"></i> Total Saldo
            </div>

            <div class="balance-hero-value">
                Rp {{ number_format($balance,0,',','.') }}
            </div>

            <div class="balance-hero-caption">
                Diperbarui {{ now()->format('d M Y') }}
            </div>
        </div>

        <div class="balance-hero-badge">
            <i class="ti ti-trending-up"></i>
        </div>

    </div>

</div>

<div class="row g-3 mb-5">

    <div class="col-md-6">

        <div class="stat-card success-card">

            <div class="stat-title"><i class="ti ti-trending-up"></i> Total Pemasukan</div>

            <div class="stat-value text-income">
                Rp {{ number_format($totalIncome,0,',','.') }}
            </div>

            <div class="stat-icon green"><i class="ti ti-trending-up"></i></div>

        </div>

    </div>

    <div class="col-md-6">

        <div class="stat-card danger-card">

            <div class="stat-title"><i class="ti ti-trending-down"></i> Total Pengeluaran</div>

            <div class="stat-value text-expense">
                Rp {{ number_format($totalExpense,0,',','.') }}
            </div>

            <div class="stat-icon red"><i class="ti ti-trending-down"></i></div>

        </div>

    </div>

</div>

<!-- ===================================================== -->
<!-- RINGKASAN PERIODE                                     -->
<!-- ===================================================== -->

<div class="page-header">
    <h2 class="page-title" style="font-size:18px;">Ringkasan Berdasarkan Periode</h2>
    <p class="page-subtitle">Laporan cepat keuangan kamu</p>
</div>

<div class="row g-3 mb-5">

    <!-- WEEKLY -->
    <div class="col-md-4">

        <a href="{{ route('transactions.report', 'weekly') }}" class="text-decoration-none">

            <div class="report-option">

                <div class="report-option-icon"><i class="ti ti-calendar-week"></i></div>

                <div class="report-option-title">Minggu Ini</div>

                <div class="report-option-desc">

                    <div class="period-val income">
                        <i class="ti ti-arrow-up-right"></i> Pemasukan: Rp {{ number_format($weeklyIncome, 0, ',', '.') }}
                    </div>

                    <div class="period-val expense">
                        <i class="ti ti-arrow-down-right"></i> Pengeluaran: Rp {{ number_format($weeklyExpense, 0, ',', '.') }}
                    </div>

                </div>

                <div class="report-option-arrow">
                    Lihat Detail →
                </div>

            </div>

        </a>

    </div>

    <!-- MONTHLY -->
    <div class="col-md-4">

        <a href="{{ route('transactions.report', 'monthly') }}" class="text-decoration-none">

            <div class="report-option">

                <div class="report-option-icon"><i class="ti ti-calendar-month"></i></div>

                <div class="report-option-title">Bulan Ini</div>

                <div class="report-option-desc">

                    <div class="period-val income">
                        <i class="ti ti-arrow-up-right"></i> Pemasukan: Rp {{ number_format($monthlyIncome, 0, ',', '.') }}
                    </div>

                    <div class="period-val expense">
                        <i class="ti ti-arrow-down-right"></i> Pengeluaran: Rp {{ number_format($monthlyExpense, 0, ',', '.') }}
                    </div>

                </div>

                <div class="report-option-arrow">
                    Lihat Detail →
                </div>

            </div>

        </a>

    </div>

    <!-- YEARLY -->
    <div class="col-md-4">

        <a href="{{ route('transactions.report', 'yearly') }}" class="text-decoration-none">

            <div class="report-option">

                <div class="report-option-icon"><i class="ti ti-calendar-stats"></i></div>

                <div class="report-option-title">Tahun Ini</div>

                <div class="report-option-desc">

                    <div class="period-val income">
                        <i class="ti ti-arrow-up-right"></i> Pemasukan: Rp {{ number_format($yearlyIncome, 0, ',', '.') }}
                    </div>

                    <div class="period-val expense">
                        <i class="ti ti-arrow-down-right"></i> Pengeluaran: Rp {{ number_format($yearlyExpense, 0, ',', '.') }}
                    </div>

                </div>

                <div class="report-option-arrow">
                    Lihat Detail →
                </div>

            </div>

        </a>

    </div>

</div>

<!-- ===================================================== -->
<!-- ALERT                                                 -->
<!-- ===================================================== -->

@if(session('success'))

    <div class="alert alert-success alert-dismissible fade show">

        <i class="ti ti-circle-check"></i>
        {{ session('success') }}

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

    </div>

@endif

<!-- ===================================================== -->
<!-- CHART SECTION                                         -->
<!-- ===================================================== -->

<div class="row g-4 mt-4">

    <div class="col-lg-6">

        <div class="chart-card">

            <div class="chart-card-header">
                <h5 class="chart-card-title"><i class="ti ti-chart-line"></i> Tren Keuangan</h5>
            </div>

            <div class="chart-card-body fixed-chart">
                <canvas id="financeChart"></canvas>
            </div>

        </div>

    </div>

    <div class="col-lg-6">

        <div class="chart-card">

            <div class="chart-card-header">
                <h5 class="chart-card-title"><i class="ti ti-chart-pie"></i> Pengeluaran per Kategori</h5>
            </div>

            <div class="chart-card-body fixed-chart">
                <canvas id="categoryChart"></canvas>
            </div>

        </div>

    </div>

</div>

<!-- ===================================================== -->
<!-- CHART SCRIPT                                          -->
<!-- ===================================================== -->

@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    const months = @json($chartData->pluck('month'));
    const incomes = @json($chartData->pluck('pemasukan'));
    const expenses = @json($chartData->pluck('pengeluaran'));

    const financeEl = document.getElementById('financeChart');

    if (financeEl) {

        new Chart(financeEl, {
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
    maintainAspectRatio: false,
    plugins: {
        legend: {
            position: 'bottom'
        }
    }
}
        });

    }

    const categoryLabels = @json($expenseByCategory->pluck('category'));
    const categoryTotals = @json($expenseByCategory->pluck('total'));

    const categoryEl = document.getElementById('categoryChart');

    if (categoryEl) {

        new Chart(categoryEl, {
            type: 'doughnut',
            data: {
                labels: categoryLabels,
                datasets: [{
                    data: categoryTotals
                }]
            },
           options: {
    responsive: true,
    maintainAspectRatio: false,
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