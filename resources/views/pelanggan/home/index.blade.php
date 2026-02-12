<x-app-layout>

<div class="max-w-7xl mx-auto">

    {{-- HERO SECTION --}}
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-2xl p-10 mb-10 shadow-lg">
        <h1 class="text-4xl font-bold mb-4">
            Selamat Datang di Toko Cihuy!
        </h1>

        <p class="text-lg text-blue-100 mb-6">
            Temukan berbagai produk menarik dengan harga terbaik. Yuk belanja sekarang!
        </p>

        <a href="{{ route('pelanggan.produk.index') }}"
           class="inline-block px-6 py-3 bg-white text-blue-700 font-semibold rounded-lg shadow hover:bg-gray-100">
            Lihat Produk
        </a>
    </div>

    {{-- PRODUK TERBARU --}}
    <h2 class="text-2xl font-bold mb-4">Produk Terbaru</h2>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">

        @foreach ($produk as $p)
        <a href="{{ route('pelanggan.produk.show', $p->id) }}"
           class="bg-white rounded-xl shadow hover:shadow-lg transition p-4">

            <img src="{{ asset('storage/'.$p->foto) }}"
                 class="w-full h-40 object-cover rounded">

            <h3 class="font-semibold text-lg mt-3">{{ $p->nama }}</h3>

            <p class="text-green-700 font-bold">
                Rp {{ number_format($p->harga, 0, ',', '.') }}
            </p>
        </a>
        @endforeach

    </div>

</div>

</x-app-layout>
