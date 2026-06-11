<!DOCTYPE html>
<html>

<head>

    <title>Keuangan Pribadi</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">


    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container d-flex justify-content-between">

        <a class="navbar-brand fw-bold" href="{{ route('transactions.index') }}">
            💰 Keuangan Pribadi
        </a>

        @auth
            <div class="d-flex align-items-center">

                <span class="text-white me-3">
                    Selamat datang, {{ Auth::user()->name }}
                </span>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button type="submit" class="btn btn-danger btn-sm">
                        Logout
                    </button>

                </form>

            </div>
        @endauth

    </div>
</nav>

    <!-- Container utama -->
<div class="container mt-4">

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

</body>

</html>