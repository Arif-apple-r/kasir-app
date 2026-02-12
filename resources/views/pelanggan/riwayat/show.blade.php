<x-app-layout>
<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="mb-6">
        <a href="{{ route('pelanggan.riwayat') }}" class="text-sm text-gray-500 hover:text-blue-600 flex items-center gap-1">
            ← Kembali ke Daftar Riwayat
        </a>
    </div>

    <div class="bg-white shadow-xl rounded-3xl overflow-hidden border border-gray-100">
        {{-- Header Detail --}}
        <div class="bg-gray-900 p-8 text-white flex justify-between items-center">
            <div>
                <p class="text-gray-400 text-sm uppercase tracking-widest mb-1">ID Transaksi</p>
                <h1 class="text-2xl font-bold">#TRX-{{ $penjualan->id }}</h1>
            </div>
            <div class="text-right">
                <p class="text-gray-400 text-sm mb-1 uppercase tracking-widest">Status</p>
                <span class="px-4 py-1 bg-blue-500 text-white rounded-full text-sm font-bold uppercase">
                    {{ $penjualan->status_pesanan }}
                </span>
            </div>
        </div>

        <div class="p-8">
            <div class="grid grid-cols-2 gap-8 mb-10">
                <div>
                    <h4 class="text-gray-400 text-xs uppercase font-bold mb-2">Waktu Transaksi</h4>
                    <p class="text-gray-800 font-medium">{{ $penjualan->created_at->format('d F Y, H:i') }}</p>
                </div>
                <div class="text-right">
                    <h4 class="text-gray-400 text-xs uppercase font-bold mb-2">Metode Pembayaran</h4>
                    <p class="text-gray-800 font-medium">{{ strtoupper($penjualan->metode_pembayaran ?? 'Cash') }}</p>
                </div>
            </div>

            <h4 class="text-lg font-bold mb-4 pb-2 border-b">Ringkasan Produk</h4>
            <div class="space-y-4 mb-10">
                @foreach ($penjualan->detail as $d)
                    <div class="flex justify-between items-center">
                        <div class="flex gap-4 items-center">
                            <div class="h-12 w-12 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                            </div>
                            <div>
                                <p class="font-bold text-gray-800">{{ $d->produk->nama }}</p>
                                <p class="text-sm text-gray-500">{{ $d->jumlah }} x Rp {{ number_format($d->harga_saat_itu, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <p class="font-semibold text-gray-900">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>

            <div class="bg-gray-50 rounded-2xl p-6 flex justify-between items-center">
                <span class="text-gray-600 font-bold text-xl">Total Bayar</span>
                <span class="text-3xl font-black text-blue-600">Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
