<x-app-layout>
<div class="max-w-5xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-black text-gray-900 mb-8 flex items-center gap-3">
        🛒 Keranjang Belanja
    </h1>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-r-lg">
            {{ session('success') }}
        </div>
    @endif

    @if (count($cart) == 0)
        <div class="bg-white rounded-3xl p-16 text-center shadow-sm border border-dashed border-gray-300">
            <p class="text-gray-400 text-xl">Keranjangmu masih sepi...</p>
            <a href="{{ route('pelanggan.produk.index') }}" class="mt-6 inline-block bg-blue-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-blue-700 transition">
                Mulai Belanja
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Daftar Barang --}}
            <div class="lg:col-span-2 space-y-4">
                @foreach ($cart as $id => $item)
                    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-5">
                        <img src="{{ asset('storage/'.$item['foto']) }}" class="w-24 h-24 object-cover rounded-xl">

                        <div class="flex-1">
                            <h2 class="font-bold text-lg text-gray-800">{{ $item['nama'] }}</h2>
                            <p class="text-blue-600 font-bold">Rp {{ number_format($item['harga'], 0, ',', '.') }}</p>

                            <div class="flex items-center mt-3 gap-4">
                                {{-- Form Update --}}
                                <form method="POST" action="{{ route('pelanggan.cart.update') }}" class="flex items-center gap-2">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <input type="number" name="jumlah" value="{{ $item['jumlah'] }}" min="1"
                                           class="w-16 p-1 border border-gray-200 rounded-lg text-center focus:ring-2 focus:ring-blue-500">
                                    <button class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-600 px-2 py-1.5 rounded-lg font-semibold transition">
                                        Update
                                    </button>
                                </form>

                                {{-- Form Hapus --}}
                                <form method="POST" action="{{ route('pelanggan.cart.delete') }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <button class="text-red-500 hover:text-red-700 p-2 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="text-right hidden md:block">
                            <p class="text-xs text-gray-400 uppercase font-bold tracking-wider">Subtotal</p>
                            <p class="font-black text-gray-900">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Ringkasan --}}
            <div class="lg:col-span-1">
                <div class="bg-gray-900 text-white p-8 rounded-3xl shadow-xl sticky top-24">
                    <h2 class="text-xl font-bold mb-6 border-b border-gray-700 pb-4">Ringkasan Pesanan</h2>

                    <div class="flex justify-between mb-4 text-gray-400">
                        <span>Total Barang</span>
                        <span>{{ collect($cart)->sum('jumlah') }} unit</span>
                    </div>

                    <div class="flex justify-between items-end mb-8">
                        <span class="text-gray-400">Total Harga</span>
                        <span class="text-2xl font-black text-blue-400">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <a href="{{ route('pelanggan.checkout') }}"
                       class="block w-full text-center bg-blue-500 hover:bg-blue-600 text-white font-black py-4 rounded-2xl transition shadow-lg shadow-blue-900/20">
                        Lanjut Checkout →
                    </a>

                    <p class="text-center text-xs text-gray-500 mt-4 italic">
                        Harga sudah termasuk pajak & kebahagiaan admin.
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>
</x-app-layout>
