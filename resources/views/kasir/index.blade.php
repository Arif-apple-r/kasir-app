<x-app-layout>

<div class="max-w-7xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-black text-gray-900 mb-8">Panel Kasir</h1>

    {{-- Navigasi Tab --}}
    <div class="flex gap-4 mb-6" x-data="{ tab: 'pos' }">
        <button @click="tab = 'pos'" :class="tab == 'pos' ? 'bg-blue-600 text-white' : 'bg-white text-gray-600'"
                class="px-6 py-2 rounded-xl font-bold shadow-sm transition">
            POS (Transaksi Toko)
        </button>
        <button @click="tab = 'online'" :class="tab == 'online' ? 'bg-orange-500 text-white' : 'bg-white text-gray-600'"
                class="px-6 py-2 rounded-xl font-bold shadow-sm transition flex items-center gap-2">
            Pesanan Online
            @if($pesananPending->count() > 0)
                <span class="bg-white text-orange-600 px-2 py-0.5 rounded-full text-xs">{{ $pesananPending->count() }}</span>
            @endif
        </button>

        {{-- Isi Tab POS --}}
        <div x-show="tab === 'pos'" class="w-full mt-6">
            <form action="{{ route('kasir.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {{-- Form Input Barang (Gunakan row.blade.php kamu di sini) --}}
                    <div class="lg:col-span-2 bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                        <h2 class="font-bold mb-4">Input Belanjaan</h2>
                        <div id="produk-list">
                            @include('kasir.partials.row')
                        </div>
                        <button type="button" onclick="addRow()" class="mt-4 text-blue-600 font-bold text-sm">+ Tambah Baris</button>
                    </div>

                    {{-- Summary & Bayar --}}
                    <div class="lg:col-span-1 bg-gray-900 text-white p-6 rounded-3xl shadow-xl">
                        <label class="block mb-2 text-gray-400">Pilih Pelanggan (Opsional)</label>
                        <select name="pelanggan_id" class="w-full bg-gray-800 border-none rounded-xl mb-6 text-white">
                            <option value="">Umum</option>
                            @foreach($pelanggan as $plg)
                                <option value="{{ $plg->id }}">{{ $plg->name }}</option>
                            @endforeach
                        </select>
                        <div class="text-sm text-gray-400 mb-1">Total Bayar</div>
                        <div class="text-3xl font-black text-green-400 mb-6" id="total-display">Rp 0</div>
                        <button type="submit" class="w-full bg-green-500 hover:bg-green-600 py-4 rounded-2xl font-black transition">
                            PROSES TRANSAKSI
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Isi Tab Pesanan Online --}}
        <div x-show="tab === 'online'" class="w-full mt-6" style="display:none">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="p-4 font-bold text-gray-600">ID</th>
                            <th class="p-4 font-bold text-gray-600">Pelanggan</th>
                            <th class="p-4 font-bold text-gray-600">Total</th>
                            <th class="p-4 font-bold text-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pesananPending as $pesan)
                        <tr class="border-b border-gray-50">
                            <td class="p-4">#{{ $pesan->id }}</td>
                            <td class="p-4">
                                <div class="font-bold">{{ $pesan->pelanggan->name }}</div>
                                <div class="text-xs text-gray-400">{{ $pesan->tanggal_penjualan }}</div>
                            </td>
                            <td class="p-4 font-bold text-blue-600">Rp {{ number_format($pesan->total_harga, 0, ',', '.') }}</td>
                            <td class="p-4">
                                <form action="{{ route('kasir.konfirmasi', $pesan->id) }}" method="POST">
                                    @csrf
                                    <button class="bg-orange-100 text-orange-600 px-4 py-2 rounded-lg font-bold hover:bg-orange-200 transition">
                                        Konfirmasi Lunas
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-10 text-center text-gray-400">Tidak ada pesanan pending saat ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="logout button">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
            Logout
        </button>
    </form>
</div>

<script>
// Duplicate row produk
function addRow() {
    fetch("{{ url('/kasir-row') }}")
        .then(res => res.text())
        .then(html => {
            document.querySelector('#produk-list').insertAdjacentHTML('beforeend', html);
        });
}

// Hitung total realtime
document.addEventListener('input', function () {

    let rows = document.querySelectorAll('.produk-row');
    let total = 0;

    rows.forEach(row => {
        let select = row.querySelector('.produk-select');
        let jumlah = row.querySelector('.jumlah-input');
        let subtotalField = row.querySelector('.subtotal');

        if (select.value && jumlah.value) {
            let harga = select.selectedOptions[0].dataset.harga;
            let subtotal = harga * jumlah.value;
            subtotalField.value = subtotal;
            total += subtotal;
        }
    });

    document.getElementById('total-display').innerText =
        "Rp " + total.toLocaleString('id-ID');
});
</script>

</x-app-layout>
