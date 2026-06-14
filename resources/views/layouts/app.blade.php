<!DOCTYPE html>
<html>

<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Keuangan Pribadi</title>
    <link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>

:root{
    --bg-primary:#0F172A;
    --bg-secondary:#172554;
    --bg-card:#1E293B;
    --border:#334155;

    --text-primary:#F8FAFC;
    --text-secondary:#94A3B8;

    --gold:#D4AF37;

    --income:#10B981;
    --expense:#EF4444;
}

body{
    font-family:'Inter',sans-serif;
    color:var(--text-primary);

    background:
    radial-gradient(circle at top left,#172554 0%,#0F172A 40%),
    linear-gradient(135deg,#0F172A,#020617);

    min-height:100vh;
}

/* =======================
   NAVBAR
======================= */

.navbar{
    background:#111827 !important;
    border-bottom:1px solid var(--border);
}

.navbar-brand{
    font-weight:700;
}

.nav-link{
    color:#E5E7EB !important;
}

/* =======================
   CARD
======================= */

.card{
    background:var(--bg-card);
    border:1px solid var(--border);
    border-radius:20px;

    box-shadow:
    0 10px 30px rgba(0,0,0,.25);
}

/* =======================
   PAGE TITLE
======================= */

.page-title{
    font-size:38px;
    font-weight:800;
}

.report-header{
    margin-bottom:40px;
}

.report-icon{
    width:75px;
    height:75px;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:36px;

    border-radius:20px;

    background:rgba(255,255,255,.06);

    border:1px solid rgba(255,255,255,.08);
}

/* =======================
   PERIOD CARD
======================= */

.period-card{
    background:rgba(255,255,255,.04);

    backdrop-filter:blur(12px);

    border:1px solid rgba(255,255,255,.08);
}

/* =======================
   STAT CARD
======================= */

.stat-card{
    background:var(--bg-card);

    border:1px solid var(--border);

    border-radius:20px;

    padding:25px;

    height:100%;

    transition:.3s;
}

.stat-card:hover{
    transform:translateY(-5px);
}

.stat-title{
    color:var(--text-secondary);
    font-size:14px;
}

.stat-value{
    font-size:42px;
    font-weight:800;
}

/* =======================
   COLORS
======================= */

.text-income{
    color:var(--income);
}

.text-expense{
    color:var(--expense);
}

/* =======================
   BUTTON
======================= */

.btn-luxury,
.btn-action-edit{
    background:var(--gold);

    color:#111827;

    border:none;

    border-radius:12px;

    font-weight:600;

    padding:10px 18px;

    text-decoration:none;

    display:inline-block;
}

.btn-luxury:hover,
.btn-action-edit:hover{
    opacity:.9;
    color:#111827;
}

.btn-action-delete{
    background:transparent;

    color:var(--expense);

    border:1px solid var(--expense);

    border-radius:12px;

    padding:8px 14px;
}

.btn-action-delete:hover{
    background:var(--expense);
    color:white;
}

/* =======================
   FORM
======================= */

.form-control,
.form-select{
    background:#0F172A;
    border:1px solid var(--border);
    color:white;
}

.form-control:focus,
.form-select:focus{
    background:#0F172A;
    color:white;
    border-color:var(--gold);
    box-shadow:none;
}

/* =======================
   TABLE
======================= */

.table-dark-luxury{
    margin:0;
    color:#F8FAFC;
}

.table-dark-luxury thead th{
    background:#111827 !important;
    color:#F8FAFC !important;

    font-size:15px;
    font-weight:700;

    letter-spacing:.5px;
    text-transform:uppercase;

    border-bottom:1px solid #334155;

    padding:18px;
}

.table-dark-luxury tbody td{
    background:#1E293B !important;

    color:#F8FAFC;

    border-color:#334155;

    padding:18px;
}

.table-dark-luxury tbody tr:hover td{
    background:#293548 !important;
}
/* =======================
   BADGE
======================= */

.income-badge{
    background:#064E3B;
    color:#34D399;

    padding:8px 14px;

    border-radius:999px;

    font-weight:600;
}

.expense-badge{
    background:#7F1D1D;
    color:#F87171;

    padding:8px 14px;

    border-radius:999px;

    font-weight:600;
}

/* =======================
   TRANSACTION
======================= */

.transaction-title{
    color:white;
    font-weight:600;
}

.category-column{
    color:#CBD5E1;
}

/* =======================
   EMPTY STATE
======================= */

.empty-state{
    padding:60px 20px;
}

.empty-icon{
    font-size:72px;
}

/* =======================
   TABLE HEADER TITLE
======================= */

.table-section-title{
    color:#F8FAFC;

    font-size:24px;

    font-weight:800;

    letter-spacing:.5px;
}

.card-header{
    background:#111827 !important;

    border-bottom:1px solid #334155 !important;
}

/* =======================
   FOOTER
======================= */

footer{
    border-top:1px solid var(--border);
    background:#111827 !important;
}

.pagination .page-item .page-link {
    background: rgba(255,255,255,.05);
    backdrop-filter: blur(10px);
    color: #fff;
    border: 1px solid rgba(255,255,255,.08);
    border-radius: 14px;
}

.pagination .page-item.active .page-link {
    background: linear-gradient(
        135deg,
        #f59e0b,
        #f97316
    );
    border: none;
}

</style>
</head>

<body>


    <nav class="navbar navbar-expand-lg shadow-sm"
     style="background:#111827;border-bottom:1px solid #334155;">

    <div class="container">

        <a class="navbar-brand fw-bold text-white" href="/">
            💰 Keuangan Pribadi
        </a>

        <button
            class="navbar-toggler"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link text-light"
                       href="{{ route('transactions.index') }}">
                        Dashboard
                    </a>
                </li>

            </ul>

        </div>

    </div>

</nav>

    <!-- Container utama -->
<div class="container py-5">   

        <!-- Alert sukses -->
        @if(session('success'))

            <div class="alert alert-success">

                {{ session('success') }}

            </div>

        @endif

        <!-- Alert error -->
        @if(session('error'))

            <div class="alert alert-danger">

                {{ session('error') }}

            </div>

        @endif

        <!-- Isi halaman -->
        @yield('content')

    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center p-3 mt-5">

        <p class="mb-0">

            © {{ date('Y') }} Aplikasi Keuangan Pribadi

        </p>

    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>