<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keuangan Pribadi</title>

    {{-- Bootstrap CSS (base grid & komponen) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Design System (override Bootstrap) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

<div class="wrapper">

    {{-- Sidebar --}}
    <aside class="sidebar">

        <a href="{{ route('transactions.index') }}" class="logo">
            <span class="logo-emoji">💰</span>
            <span class="logo-text">
                Keuangan Pribadi
                <small>Personal Finance</small>
            </span>
        </a>

        <ul class="menu">

            <li>
                <a href="{{ route('transactions.index') }}"
                   class="{{ request()->routeIs('transactions.index') ? 'active-menu' : '' }}">
                    <span class="menu-icon">📊</span>
                    <span>Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{ route('transactions.list') }}"
                   class="{{ request()->routeIs('transactions.list') ? 'active-menu' : '' }}">
                    <span class="menu-icon">💰</span>
                    <span>Money Tracker</span>
                </a>
            </li>

            <li>
                <a href="{{ route('categories.index') }}"
                   class="{{ request()->routeIs('categories.*') ? 'active-menu' : '' }}">
                    <span class="menu-icon">🏷️</span>
                    <span>Kategori</span>
                </a>
            </li>

            <li>
                <a href="{{ route('reports.index') }}"
                   class="{{ request()->routeIs('reports.*') ? 'active-menu' : '' }}">
                    <span class="menu-icon">📈</span>
                    <span>Laporan</span>
                </a>
            </li>

            <li>
                <a href="{{ route('tools.index') }}"
                   class="{{ request()->routeIs('tools.index') ? 'active-menu' : '' }}">
                    <span class="menu-icon">📂</span>
                    <span>Import / Export</span>
                </a>
            </li>

        </ul>

       <div class="sidebar-footer">

    <a href="{{ route('transactions.create') }}" class="add-btn">
        + Tambah Data
    </a>

    <form action="{{ route('logout') }}" method="POST" class="mt-2">
        @csrf
        <button type="submit" class="logout-btn">
            🚪 Keluar
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