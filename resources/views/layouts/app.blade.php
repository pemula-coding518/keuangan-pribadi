<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keuangan Pribadi</title>

    {{-- Bootstrap CSS (base grid & komponen) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Tabler Icons (ikon, menggantikan emoji) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.34.0/dist/tabler-icons.min.css">

    {{-- Design System (override Bootstrap) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

<div class="wrapper">

    {{-- Sidebar --}}
    <aside class="sidebar">

        <a href="{{ route('transactions.index') }}" class="logo">
            <span class="logo-icon"><i class="ti ti-wallet"></i></span>
            <span class="logo-text">
                Keuangan Pribadi
                <small>Personal Finance</small>
            </span>
        </a>

        <ul class="menu">

            <li>
                <a href="{{ route('transactions.index') }}"
                   class="{{ request()->routeIs('transactions.index') ? 'active-menu' : '' }}">
                    <span class="menu-icon"><i class="ti ti-layout-dashboard"></i></span>
                    <span>Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{ route('transactions.list') }}"
                   class="{{ request()->routeIs('transactions.list') ? 'active-menu' : '' }}">
                    <span class="menu-icon"><i class="ti ti-receipt-2"></i></span>
                    <span>Money Tracker</span>
                </a>
            </li>

            <li>
                <a href="{{ route('categories.index') }}"
                   class="{{ request()->routeIs('categories.*') ? 'active-menu' : '' }}">
                    <span class="menu-icon"><i class="ti ti-tags"></i></span>
                    <span>Kategori</span>
                </a>
            </li>

            <li>
                <a href="{{ route('reports.index') }}"
                   class="{{ request()->routeIs('reports.*') ? 'active-menu' : '' }}">
                    <span class="menu-icon"><i class="ti ti-chart-line"></i></span>
                    <span>Laporan</span>
                </a>
            </li>

            <li>
                <a href="{{ route('tools.index') }}"
                   class="{{ request()->routeIs('tools.index') ? 'active-menu' : '' }}">
                    <span class="menu-icon"><i class="ti ti-file-export"></i></span>
                    <span>Import / Export</span>
                </a>
            </li>

        </ul>

        <div class="sidebar-footer">

            <a href="{{ route('transactions.create') }}" class="add-btn">
                <i class="ti ti-plus"></i>
                <span>Tambah Data</span>
            </a>

            <form action="{{ route('logout') }}" method="POST" class="mt-2">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="ti ti-logout-2"></i>
                    <span>Keluar</span>
                </button>
            </form>

        </div>

    </aside>

    {{-- Main Content --}}
    <main class="content">
        @yield('content')
    </main>

</div>

{{-- Bootstrap JS (diperlukan untuk alert dismiss, dropdown, dll) --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')

</body>

</html>