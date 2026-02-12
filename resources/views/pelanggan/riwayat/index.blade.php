<x-app-layout>
<div class="max-w-7xl mx-auto py-8 px-4">
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-extrabold text-gray-900">Riwayat Belanja</h2>
        <span class="bg-blue-100 text-blue-700 px-4 py-1 rounded-full text-sm font-medium">
            Total {{ $riwayat->count() }} Transaksi
        </span>
    </div>

    @if ($riwayat->isEmpty())
        <div class="bg-white rounded-2xl shadow-sm p-12 text-center">
            <div class="text-gray-400 mb-4">
                <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>
            <p class="text-gray-500 text-lg">Belum ada transaksi nih. Yuk belanja!</p>
            <a href="{{ route('pelanggan.produk.index') }}" class="mt-4 inline-block text-blue-600 font-semibold hover:underline">Lihat Katalog →</a>
        </div>
    @else
        <div class="bg-white shadow-sm rounded-2xl overflow-hidden border border-gray-100">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">ID Transaksi</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Pembayaran</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($riwayat as $r)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-mono text-sm text-gray-600">#TRX-{{ $r->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $r->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-6 py-4 text-sm font-bold text-gray-900">Rp {{ number_format($r->total_harga, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColor = [
                                        'selesai' => 'bg-green-100 text-green-700',
                                        'pending' => 'bg-amber-100 text-amber-700',
                                        'proses'  => 'bg-blue-100 text-blue-700',
                                        'batal'   => 'bg-red-100 text-red-700',
                                    ][$r->status_pesanan] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $statusColor }}">
                                    {{ $r->status_pesanan }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('pelanggan.riwayat.show', $r->id) }}"
                                   class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 shadow-sm transition">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
</x-app-layout>
