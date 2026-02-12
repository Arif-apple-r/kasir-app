<x-app-layout>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">

        <h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard Admin</h1>

        {{-- CARD METRICS --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

            <div class="p-6 bg-white rounded-xl shadow hover:shadow-lg transition">
                <p class="text-gray-500">Total Produk</p>
                <h2 class="text-3xl font-bold">{{ $totalProduk }}</h2>
            </div>

            <div class="p-6 bg-white rounded-xl shadow hover:shadow-lg transition">
                <p class="text-gray-500">Total Pelanggan</p>
                <h2 class="text-3xl font-bold">{{ $totalPelanggan }}</h2>
            </div>

            <div class="p-6 bg-white rounded-xl shadow hover:shadow-lg transition">
                <p class="text-gray-500">Total Karyawan</p>
                <h2 class="text-3xl font-bold">{{ $totalKaryawan }}</h2>
            </div>

            <div class="p-6 bg-white rounded-xl shadow hover:shadow-lg transition">
                <p class="text-gray-500">Penjualan Hari Ini</p>
                <h2 class="text-3xl font-bold">
                    Rp {{ number_format($penjualanHariIni, 0, ',', '.') }}
                </h2>
            </div>

            <div class="p-6 bg-white rounded-xl shadow hover:shadow-lg transition md:col-span-2">
                <p class="text-gray-500">Pesanan Pending</p>
                <h2 class="text-3xl font-bold">{{ $pendingCount }}</h2>
                <p class="text-sm text-gray-500 mt-1">
                    Menunggu konfirmasi kasir
                </p>
            </div>

        </div>

        {{-- TABLE PENJUALAN TERBARU --}}
        <div class="mt-10 bg-white p-6 rounded-xl shadow">

            <h2 class="text-xl font-semibold mb-4">Penjualan Terbaru</h2>

            <div class="overflow-x-auto">
                <table class="min-w-full border rounded-lg overflow-hidden">

                    <thead>
                        <tr class="bg-gray-100 text-gray-700">
                            <th class="px-4 py-2 text-left">ID</th>
                            <th class="px-4 py-2 text-left">Pelanggan</th>
                            <th class="px-4 py-2 text-left">Kasir</th>
                            <th class="px-4 py-2 text-left">Total</th>
                            <th class="px-4 py-2 text-left">Tanggal</th>
                            <th class="px-4 py-2 text-left">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($penjualanTerbaru as $p)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-4 py-2">{{ $p->id }}</td>
                            <td class="px-4 py-2">{{ optional($p->pelanggan)->name ?? 'Umum' }}</td>
                            <td class="px-4 py-2">{{ optional($p->karyawan)->name ?? 'Tidak Ada' }}</td>
                            <td class="px-4 py-2">
                                Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-2">{{ $p->tanggal_penjualan }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 rounded text-xs
                                    @if($p->status_pesanan === 'selesai') bg-green-100 text-green-700
                                    @elseif($p->status_pesanan === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($p->status_pesanan === 'diproses') bg-blue-100 text-blue-700
                                    @else bg-red-100 text-red-700 @endif">
                                    {{ ucfirst($p->status_pesanan) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        </div>

    </div>

</x-app-layout>
