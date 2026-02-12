<x-app-layout>

    <div class="max-w-4xl mx-auto">

        <h1 class="text-2xl font-bold mb-6">
            Detail Penjualan #{{ $penjualan->id }}
        </h1>

        <div class="bg-white p-6 rounded-xl shadow">

            <p><strong>Pelanggan:</strong> {{ $penjualan->pelanggan->name ?? 'Umum' }}</p>
            <p><strong>Kasir:</strong> {{ $penjualan->karyawan->name }}</p>
            <p><strong>Tanggal:</strong> {{ $penjualan->tanggal_penjualan }}</p>
            <p><strong>Total Harga:</strong>
                Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}
            </p>

            <hr class="my-4">

            <h2 class="text-xl font-semibold mb-3">Detail Produk</h2>

            <table class="min-w-full border">
                <thead>
                    <tr class="bg-gray-100 text-gray-600">
                        <th class="py-2 px-3 text-left">Produk</th>
                        <th class="py-2 px-3 text-left">Harga</th>
                        <th class="py-2 px-3 text-left">Jumlah</th>
                        <th class="py-2 px-3 text-left">Subtotal</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($penjualan->detail as $d)
                    <tr class="border-b">
                        <td class="py-2 px-3">{{ $d->produk->nama }}</td>
                        <td class="py-2 px-3">
                            Rp {{ number_format($d->harga_saat_itu, 0, ',', '.') }}
                        </td>
                        <td class="py-2 px-3">
                            {{ $d->jumlah }}
                        </td>
                        <td class="py-2 px-3">
                            Rp {{ number_format($d->subtotal, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <a href="{{ route('kasir.penjualan.print', $penjualan->id) }}"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 ml-2">
                🖨️ Print
            </a>

        </div>

    </div>

</x-app-layout>
