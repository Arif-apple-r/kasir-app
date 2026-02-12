<x-app-layout>

<div class="max-w-7xl mx-auto">

    {{-- JUDUL --}}
    <h1 class="text-3xl font-bold mb-6">Semua Produk</h1>

    {{-- SEARCH BAR --}}
    <form method="GET" action="{{ route('pelanggan.produk.index') }}"
          class="mb-6">

        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Cari produk..."
               class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-blue-500">
    </form>

    {{-- GRID PRODUK --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">

        @forelse ($produk as $p)
        <a href="{{ route('pelanggan.produk.show', $p->id) }}"
           class="bg-white rounded-xl shadow hover:shadow-lg transition p-4">

            <img src="{{ asset('storage/'.$p->foto) }}"
                 class="w-full h-40 object-cover rounded">

            <h3 class="font-semibold text-lg mt-3">{{ $p->nama }}</h3>

            <p class="text-green-700 font-bold">
                Rp {{ number_format($p->harga, 0, ',', '.') }}
            </p>

            <span class="text-gray-500 text-sm block mt-1">
                Stok: {{ $p->stok }}
            </span>

        </a>
        @empty
        <p class="col-span-4 text-center text-gray-500">
            Tidak ada produk ditemukan.
        </p>
        @endforelse

    </div>

    {{-- PAGINATION --}}
    <div class="mt-8">
        {{ $produk->links() }}
    </div>

</div>

</x-app-layout>
