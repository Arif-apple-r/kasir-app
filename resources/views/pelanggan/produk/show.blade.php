<x-app-layout>

<div class="max-w-6xl mx-auto">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

        {{-- FOTO PRODUK --}}
        <div>
            <img src="{{ asset('storage/'.$produk->foto) }}"
                 class="w-full h-96 object-cover rounded-2xl shadow">
        </div>

        {{-- DETAIL PRODUK --}}
        <div class="flex flex-col justify-center">

            <h1 class="text-4xl font-bold mb-3">{{ $produk->nama }}</h1>

            <p class="text-3xl text-green-600 font-semibold mb-4">
                Rp {{ number_format($produk->harga, 0, ',', '.') }}
            </p>

            <p class="text-gray-700 mb-6">
                Stok tersedia: <strong>{{ $produk->stok }}</strong>
            </p>

            {{-- Ganti form lama dengan ini --}}
            <form method="POST" action="{{ route('pelanggan.cart.add') }}" class="space-y-4">
                @csrf

                {{-- 1. Tambahkan Hidden Input untuk ID Produk --}}
                <input type="hidden" name="produk_id" value="{{ $produk->id }}">

                <div>
                    <label class="font-semibold text-gray-700">Jumlah:</label>
                    <input type="number" name="jumlah" value="1" min="1" max="{{ $produk->stok }}"
                        class="w-24 p-2 border border-gray-300 rounded-lg ml-2 focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- 2. Pastikan type-nya adalah "submit" --}}
                <button type="submit"
                        class="w-full md:w-auto px-8 py-3 bg-blue-600 text-white rounded-xl text-lg font-bold hover:bg-blue-700 shadow-lg transition-transform active:scale-95">
                    🛒 Tambah ke Keranjang
                </button>
            </form>

        </div>

    </div>

    {{-- DESKRIPSI OPSIONAL --}}
    <div class="mt-10 bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-bold mb-3">Deskripsi Produk</h2>

        <p class="text-gray-700 leading-relaxed">
            {{ $produk->deskripsi ?? 'Belum ada deskripsi untuk produk ini.' }}
        </p>
    </div>

</div>

</x-app-layout>
