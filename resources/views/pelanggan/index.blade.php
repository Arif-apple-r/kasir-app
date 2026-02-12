<x-app-layout>

<div class="max-w-7xl mx-auto">

    <h1 class="text-3xl font-bold mb-6">Katalog Produk</h1>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">

        @foreach ($produk as $p)
        <a href="{{ route('pelanggan.produk.show', $p->id) }}"
           class="bg-white rounded-xl shadow hover:shadow-lg transition p-4">

            <img src="{{ asset('storage/'.$p->foto) }}"
                 class="w-full h-40 object-cover rounded">

            <h2 class="font-semibold text-lg mt-3">{{ $p->nama }}</h2>

            <p class="text-green-700 font-bold">
                Rp {{ number_format($p->harga, 0, ',', '.') }}
            </p>

            <span class="text-sm text-gray-500">Stok: {{ $p->stok }}</span>

        </a>
        @endforeach

    </div>

</div>

</x-app-layout>
