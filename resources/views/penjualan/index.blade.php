<x-app-layout>

    <div class="max-w-6xl mx-auto">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Riwayat Penjualan</h1>
            <a href="{{ route('penjualan.printAll') }}"
               class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-bold">
                🖨️ Print Laporan Semua
            </a>
        </div>

        <div class="bg-white shadow rounded-xl p-6">

            <table class="min-w-full border">

                <thead>
                    <tr class="bg-gray-100 text-gray-600">
                        <th class="py-3 px-4 text-left">ID</th>
                        <th class="py-3 px-4 text-left">Pelanggan</th>
                        <th class="py-3 px-4 text-left">Kasir</th>
                        <th class="py-3 px-4 text-left">Total</th>
                        <th class="py-3 px-4 text-left">Tanggal</th>
                        <th class="py-3 px-4 text-left">Aksi</th>
                        <th class="py-3 px-4 text-left">Status</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($penjualan as $p)
                    <tr class="border-b hover:bg-gray-50">

                        <td class="py-3 px-4">{{ $p->id }}</td>

                        <td class="py-3 px-4">
                            {{ $p->pelanggan->name ?? 'Umum' }}
                        </td>

                        <td class="py-3 px-4">
                            {{ optional($p->karyawan)->name ?? '-' }}
                        </td>

                        <td class="py-3 px-4">
                            Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                        </td>

                        <td class="py-3 px-4">
                            {{ $p->tanggal_penjualan }}
                        </td>

                        <td class="py-3 px-4">
                            <a href="{{ route('penjualan.show', $p->id) }}"
                               class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Detail
                            </a>
                        </td>

                        <td class="py-3 px-4">
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

</x-app-layout>

