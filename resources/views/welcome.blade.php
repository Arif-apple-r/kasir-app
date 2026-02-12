<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KasirCihuyyy</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 text-gray-900">

    <nav class="flex justify-between items-center px-8 py-6 bg-white shadow-sm">
        <div class="flex items-center space-x-2">
            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-xl">
                K
            </div>
            <span class="text-xl font-bold tracking-tight">Kasir<span class="text-blue-600">Cihuy!</span></span>
        </div>

        <div class="space-x-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-blue-600 transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-blue-600 transition">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 px-5 py-2.5 bg-blue-600 text-white rounded-full font-semibold hover:bg-blue-700 transition shadow-md">
                            Daftar Sekarang
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-8 py-20 flex flex-col md:flex-row items-center">
        <div class="md:w-1/2 mb-10 md:mb-0">
            <span class="bg-blue-100 text-blue-700 px-4 py-1 rounded-full text-sm font-bold uppercase tracking-wide">
                All-in-One Solution
            </span>
            <h1 class="text-5xl md:text-6xl font-extrabold mt-6 leading-tight">
                Kelola Kasir & <br>
                <span class="text-blue-600">Toko Online</span> <br>
                Dalam Satu Genggaman.
            </h1>
            <p class="mt-6 text-lg text-gray-600 leading-relaxed max-w-md">
                Bantu UMKM naik kelas. Dari pencatatan transaksi kasir (POS) hingga jualan online ke seluruh dunia tanpa ribet.
            </p>
            <div class="mt-10 flex space-x-4">
                <a href="{{ route('register') }}" class="px-8 py-4 bg-gray-900 text-white rounded-xl font-bold hover:bg-gray-800 transition shadow-lg">
                    Mulai Gratis
                </a>
            </div>
        </div>

        <div class="md:w-1/2 flex justify-center">
            <div class="relative w-full max-w-lg">
                <div class="absolute top-0 -left-4 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
                <div class="absolute top-0 -right-4 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
                <div class="bg-white p-8 rounded-2xl shadow-2xl relative border border-gray-100">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center border-b pb-4">
                            <span class="font-bold">Penjualan Hari Ini</span>
                            <span class="text-green-500 font-bold">+24%</span>
                        </div>
                        <div class="h-4 w-full bg-gray-100 rounded"></div>
                        <div class="h-4 w-3/4 bg-gray-100 rounded"></div>
                        <div class="grid grid-cols-3 gap-4 mt-6">
                            <div class="h-20 bg-blue-50 rounded-lg"></div>
                            <div class="h-20 bg-blue-50 rounded-lg"></div>
                            <div class="h-20 bg-blue-50 rounded-lg"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- <section id="fitur" class="bg-white py-16 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-8 grid grid-cols-1 md:grid-cols-3 gap-12 text-center">
            <div>
                <h3 class="text-3xl font-bold text-blue-600">POS Cepat</h3>
                <p class="mt-2 text-gray-500">Transaksi kasir secepat kilat dengan sistem scan barcode.</p>
            </div>
            <div>
                <h3 class="text-3xl font-bold text-blue-600">E-Commerce</h3>
                <p class="mt-2 text-gray-500">Produk di kasir otomatis tersinkron ke toko online kamu.</p>
            </div>
            <div>
                <h3 class="text-3xl font-bold text-blue-600">Laporan Realtime</h3>
                <p class="mt-2 text-gray-500">Pantau stok dan laba rugi kapan saja, di mana saja.</p>
            </div>
        </div>
    </section> --}}

</body>
</html>
