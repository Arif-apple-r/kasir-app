<x-app-layout>
    <div class="max-w-6xl mx-auto">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Daftar Produk</h1>

            <a href="{{ route('produk.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                + Tambah Produk
            </a>
        </div>

        <div class="bg-white shadow rounded-xl p-6">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b text-gray-600">
                        <th class="py-3 text-left">Foto</th>
                        <th class="py-3 text-left">Nama Produk</th>
                        <th class="py-3 text-left">Harga</th>
                        <th class="py-3 text-left">Stok</th>
                        <th class="py-3 text-left">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($produk as $p)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3">
                            @if ($p->foto)
                                <img src="{{ asset('storage/' . $p->foto) }}"
                                     class="h-14 w-14 object-cover rounded">
                            @else
                                <div class="h-14 w-14 bg-gray-200 rounded"></div>
                            @endif
                        </td>

                        <td class="py-3">{{ $p->nama }}</td>
                        <td class="py-3">Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                        <td class="py-3">{{ $p->stok }}</td>

                        <td class="py-3">
                            <div class="flex space-x-2">

                                <a href="{{ route('produk.edit', $p->id) }}"
                                   class="px-3 py-1 bg-yellow-600 text-white rounded hover:bg-yellow-700">
                                    Edit
                                </a>

                                <form action="{{ route('produk.destroy', $p->id) }}" method="POST"
                                      onsubmit="return confirm('Anda yakin ingin menghapus?');">
                                    @csrf
                                    @method('DELETE')

                                    <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                        Hapus
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>
</x-app-layout>
