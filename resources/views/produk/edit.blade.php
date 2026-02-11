<x-app-layout>
    <div class="max-w-3xl mx-auto">

        <h1 class="text-2xl font-bold mb-6">Edit Produk</h1>

        <form method="POST" action="{{ route('produk.update', $produk->id) }}" enctype="multipart/form-data"
              class="bg-white p-6 rounded-xl shadow">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-semibold">Nama Produk</label>
                <input type="text" name="nama" value="{{ $produk->nama }}"
                       class="w-full border rounded-lg p-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold">Deskripsi</label>
                <textarea name="deskripsi" class="w-full border rounded-lg p-2">{{ $produk->deskripsi }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block font-semibold">Harga</label>
                <input type="number" name="harga" value="{{ $produk->harga }}"
                       class="w-full border rounded-lg p-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold">Stok</label>
                <input type="number" name="stok" value="{{ $produk->stok }}"
                       class="w-full border rounded-lg p-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold">Foto Produk</label>
                @if ($produk->foto)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $produk->foto) }}" width="120" class="rounded-lg shadow-sm">
                        <p class="text-xs text-gray-500 mt-1">*Foto saat ini</p>
                    </div>
                @endif
                <input type="file" name="foto" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>

            <div class="flex items-center gap-4">
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Update Produk
                </button>
                <a href="{{ route('produk.index') }}" class="text-gray-600 hover:underline text-sm">
                    Kembali
                </a>
            </div>

        </form>

    </div>
</x-app-layout>
