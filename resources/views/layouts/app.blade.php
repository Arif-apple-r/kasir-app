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
            @include('layouts.partials.adminsidebar')
        @endif

        @if(Auth::check() && Auth::user()->role === 'karyawan')
            @include('layouts.partials.karyawansidebar')
        @endif

        @if(Auth::check() && Auth::user()->role === 'pelanggan')
            @include('layouts.partials.pelanggansidebar')
        @endif

        {{-- ========== END SIDEBAR ========== --}}

        {{-- ========== MAIN CONTENT ========== --}}
        <main class="flex-1 p-8">
            {{ $slot }}
        </main>

    </div>
</body>
</html>
