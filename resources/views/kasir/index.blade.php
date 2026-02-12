<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-4" x-data="{ tab: '{{ request('tab', 'pos') }}' }">

        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-black text-gray-900">Panel Kasir</h1>
                <p class="text-gray-500 text-sm">Kelola transaksi toko dan online dalam satu tempat.</p>
            </div>

            {{-- <div class="logout-button">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-5 py-2.5 bg-red-50 text-red-600 font-bold rounded-xl hover:bg-red-600 hover:text-white transition-all duration-200">
                        Keluar Panel
                    </button>
                </form>
            </div> --}}
        </div>

        @if (session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-r-lg shadow-sm">
                <span class="font-bold">Sukses!</span> {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-r-lg shadow-sm">
                <span class="font-bold">Error!</span> {{ session('error') }}
            </div>
        @endif

        {{-- Navigasi Tab --}}
        {{-- <div class="flex gap-3 mb-8 bg-gray-100 p-1.5 rounded-2xl w-fit">
            <button @click="tab = 'pos'"
                :class="tab == 'pos' ? 'bg-white text-blue-600 shadow-md' : 'text-gray-500 hover:text-gray-700'"
                class="px-6 py-2.5 rounded-xl font-bold transition-all duration-200">
                POS
            </button>
            <button @click="tab = 'online'"
                :class="tab == 'online' ? 'bg-white text-orange-600 shadow-md' : 'text-gray-500 hover:text-gray-700'"
                class="px-6 py-2.5 rounded-xl font-bold transition-all duration-200 flex items-center gap-2">
                Pesanan Online
                @if($pesananPending->count() > 0)
                    <span class="bg-orange-500 text-white px-2 py-0.5 rounded-full text-[10px]">{{ $pesananPending->count() }}</span>
                @endif
            </button>
            <button @click="tab = 'me'"
                :class="tab == 'me' ? 'bg-white text-gray-900 shadow-md' : 'text-gray-500 hover:text-gray-700'"
                class="px-6 py-2.5 rounded-xl font-bold transition-all duration-200">
                Riwayat Saya
            </button>
        </div> --}}

        {{-- Isi Tab POS --}}
        <div x-show="tab === 'pos'" x-transition>
            <form action="{{ route('kasir.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                    {{-- Form Input Barang --}}
                    <div class="lg:col-span-2 bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="font-black text-xl text-gray-800">Input Belanjaan</h2>
                            <button type="button" onclick="addRow()" class="text-blue-600 hover:text-blue-700 font-bold text-sm bg-blue-50 px-4 py-2 rounded-lg transition">
                                + Tambah Baris
                            </button>
                        </div>

                        <div id="produk-list" class="space-y-4">
                            @include('kasir.partials.row')
                        </div>
                    </div>

                    {{-- Summary & Bayar (Sticky) --}}
                    <div class="lg:col-span-1 sticky top-6">
                        <div class="bg-gray-900 text-white p-8 rounded-[2.5rem] shadow-2xl ring-8 ring-gray-50">
                            <div class="mb-8">
                                <label class="block mb-3 text-sm text-gray-400 font-medium">Pilih Pelanggan</label>
                                <select name="pelanggan_id" class="w-full bg-gray-800 border-none rounded-2xl py-3 px-4 text-white focus:ring-2 focus:ring-blue-500">
                                    <option value="">Umum (Guest)</option>
                                    @foreach($pelanggan as $plg)
                                        <option value="{{ $plg->id }}">{{ $plg->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="space-y-4 mb-8">
                                <div class="flex justify-between items-center pb-4 border-b border-gray-800">
                                    <span class="text-gray-400 text-sm">Total Item</span>
                                    <span class="font-bold" id="item-count">0</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-400 text-sm">Total Bayar</span>
                                    <span class="text-3xl font-black text-green-400" id="total-display">Rp 0</span>
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-green-500 hover:bg-green-400 hover:scale-[1.02] active:scale-95 py-5 rounded-2xl font-black text-lg transition-all duration-200 shadow-lg shadow-green-900/20">
                                PROSES TRANSAKSI
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- Isi Tab Pesanan Online --}}
        <div x-show="tab === 'online'" x-transition style="display:none">
            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="p-6 font-bold text-gray-600 uppercase text-xs tracking-wider">ID Pesanan</th>
                            <th class="p-6 font-bold text-gray-600 uppercase text-xs tracking-wider">Pelanggan</th>
                            <th class="p-6 font-bold text-gray-600 uppercase text-xs tracking-wider">Total Tagihan</th>
                            <th class="p-6 font-bold text-gray-600 uppercase text-xs tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($pesananPending as $pesan)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="p-6 font-mono font-bold text-gray-400">#{{ $pesan->id }}</td>
                            <td class="p-6">
                                <div class="font-bold text-gray-800">{{ $pesan->pelanggan->name }}</div>
                                <div class="text-xs text-gray-400">{{ $pesan->tanggal_penjualan }}</div>
                            </td>
                            <td class="p-6">
                                <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-full font-black text-sm">
                                    Rp {{ number_format($pesan->total_harga, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="p-6 text-right">
                                <form action="{{ route('kasir.konfirmasi', $pesan->id) }}" method="POST">
                                    @csrf
                                    <button class="bg-orange-500 text-white px-6 py-2 rounded-xl font-bold hover:bg-orange-600 transition shadow-sm">
                                        Konfirmasi Lunas
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-20 text-center">
                                <div class="flex flex-col items-center">
                                    <span class="text-4xl mb-4">☕</span>
                                    <p class="text-gray-400 font-medium">Tidak ada pesanan pending saat ini.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Isi Tab Transaksi Saya --}}
        <div x-show="tab === 'me'" x-transition style="display:none">
            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                    <h2 class="font-black text-2xl text-gray-800">Ringkasan Selesai</h2>
                    <div class="bg-green-50 px-6 py-3 rounded-2xl">
                        <span class="text-green-600 text-sm font-bold uppercase tracking-widest">Omzet Hari Ini</span>
                        <div class="text-2xl font-black text-green-700">Rp {{ number_format($todayTotal, 0, ',', '.') }}</div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead>
                            <tr class="text-gray-400 text-sm uppercase">
                                <th class="px-4 py-4 text-left font-bold">Nota</th>
                                <th class="px-4 py-4 text-left font-bold">Pelanggan</th>
                                <th class="px-4 py-4 text-left font-bold">Waktu</th>
                                <th class="px-4 py-4 text-right font-bold">Total</th>
                                <th class="px-4 py-4 text-right font-bold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse ($transaksiTerbaruSaya as $tx)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-4 font-bold text-gray-800">#{{ $tx->id }}</td>
                                <td class="px-4 py-4 text-gray-600">{{ optional($tx->pelanggan)->name ?? 'Umum' }}</td>
                                <td class="px-4 py-4 text-gray-400 text-sm">{{ $tx->created_at->format('H:i') }} WIB</td>
                                <td class="px-4 py-4 text-right font-black text-gray-900">Rp {{ number_format($tx->total_harga, 0, ',', '.') }}</td>
                                <td class="px-4 py-4 text-right">
                                    <a href="{{ route('kasir.penjualan.show', $tx->id) }}"
                                       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                        Detail
                                    </a>
                                    <a href="{{ route('kasir.penjualan.print', $tx->id) }}"
                                       class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 ml-2">
                                        🖨️ Print
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-12 text-center text-gray-400">Belum ada transaksi hari ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
        let count = 0;

        rows.forEach(row => {
            let select = row.querySelector('.produk-select');
            let jumlah = row.querySelector('.jumlah-input');
            let subtotalField = row.querySelector('.subtotal');

            if (select.value && jumlah.value) {
                let harga = select.selectedOptions[0].dataset.harga;
                let subtotal = harga * jumlah.value;
                subtotalField.value = subtotal;
                total += subtotal;
                count += parseInt(jumlah.value);
            }
        });

        document.getElementById('total-display').innerText = "Rp " + total.toLocaleString('id-ID');
        document.getElementById('item-count').innerText = count;
    });
    </script>
</x-app-layout>
