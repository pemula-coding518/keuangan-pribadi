<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keuangan Pribadi</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>

<div class="wrapper">

    {{-- Sidebar --}}
    <aside class="sidebar">

        <div class="logo">
            💰 <span>Keuangan Pribadi</span>
        </div>

        <ul class="menu">

            <li>
                <a href="{{ route('transactions.index') }}"
                   class="{{ request()->routeIs('transactions.index') ? 'active-menu' : '' }}">
                    📊 Dashboard
                </a>
            </li>

            <li>
                <a href="{{ route('transactions.list') }}"
                   class="{{ request()->routeIs('transactions.list') ? 'active-menu' : '' }}">
                    💰 Money Tracker
                </a>
            </li>

            <li>
                <a href="{{ route('categories.index') }}"
                   class="{{ request()->routeIs('categories.*') ? 'active-menu' : '' }}">
                    🏷️ Kategori
                </a>
            </li>

          <li>
    <a href="{{ route('reports.index') }}"
       class="{{ request()->routeIs('reports.*') ? 'active-menu' : '' }}">
        📈 Laporan
    </a>
</li>   

            <li>
                <a href="{{ route('tools.index') }}"
                   class="{{ request()->routeIs('tools.index') ? 'active-menu' : '' }}">
                    📂 Import / Export
                </a>
            </li>

        </ul>

        <div class="sidebar-footer">

            <a href="{{ route('transactions.create') }}"
               class="btn add-btn w-100">
                + Tambah Data
            </a>

        </div>

    </aside>

    {{-- Main Content --}}
    <main class="content">

        @yield('content')

    </main>

</div>

</body>

</html>