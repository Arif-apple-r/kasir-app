<x-app-layout>
    <div class="max-w-3xl mx-auto">

        <h1 class="text-2xl font-bold mb-6">Tambah Produk</h1>

        <form method="POST" action="{{ route('produk.store') }}" enctype="multipart/form-data"
              class="bg-white p-6 rounded-xl shadow">
            @csrf

            <div class="mb-4">
                <label class="block font-semibold">Nama Produk</label>
                <input type="text" name="nama"
                       class="w-full border rounded-lg p-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold">Deskripsi</label>
                <textarea name="deskripsi" rows="3" class="w-full border rounded-lg p-2" placeholder="Jelaskan detail produk..."></textarea>
            </div>

            <div class="mb-4">
                <label class="block font-semibold">Harga</label>
                <input type="number" name="harga"
                       class="w-full border rounded-lg p-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold">Stok</label>
                <input type="number" name="stok"
                       class="w-full border rounded-lg p-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold">Foto Produk</label>
                <input type="file" name="foto" class="w-full">
            </div>

            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Simpan
            </button>

        </form>

    </div>
</x-app-layout>
