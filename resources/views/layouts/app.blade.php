<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex">

        {{-- ========== SIDEBAR UNTUK ADMIN SAJA ========== --}}
        @if(Auth::check() && Auth::user()->role === 'admin')
            <aside class="w-64 bg-gray-900 text-gray-200 flex flex-col">

                <!-- Logo -->
                <div class="p-6 text-2xl font-bold text-white border-b border-gray-700">
                    Admin Panel
                </div>

                <!-- Menu -->
                <nav class="flex-1 p-4 space-y-1">

                    <a href="{{ route('admin.dashboard') }}"
                    class="block px-4 py-2 rounded-lg
                            {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700' }}">
                        Dashboard
                    </a>

                    <a href="{{ route('produk.index') }}"
                    class="block px-4 py-2 rounded-lg
                            {{ request()->routeIs('produk.*') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700' }}">
                        Produk
                    </a>

                    <a href="{{ route('penjualan.index') }}"
                    class="block px-4 py-2 rounded-lg
                            {{ request()->routeIs('penjualan.*') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700' }}">
                        Penjualan
                    </a>

                    <a href="{{ route('karyawan.index') }}"
                    class="block px-4 py-2 rounded-lg
                            {{ request()->routeIs('karyawan.*') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700' }}">
                        Karyawan
                    </a>
                </nav>

                {{-- LOGOUT BUTTON --}}
                <form method="POST" action="{{ route('logout') }}" class="mt-6">
                    @csrf
                    <button type="submit"
                            class="block w-full text-left px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white font-semibold">
                        Logout
                    </button>
                </form>
            </aside>
        @endif
        {{-- ========== END SIDEBAR ========== --}}

        {{-- ========== MAIN CONTENT ========== --}}
        <main class="flex-1 p-8">
            {{ $slot }}
        </main>

    </div>
</body>
</html>
