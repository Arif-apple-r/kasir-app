<x-app-layout>

<div class="max-w-4xl mx-auto">

    <h1 class="text-3xl font-bold mb-6">Checkout</h1>

    {{-- LIST ITEM --}}
    <div class="bg-white rounded-xl shadow p-6 mb-8">

        @foreach ($cart as $item)
        <div class="flex justify-between items-center border-b py-3">

            <div>
                <h2 class="font-bold text-lg">{{ $item['nama'] }}</h2>
                <p class="text-gray-500">
                    {{ $item['jumlah'] }} x Rp {{ number_format($item['harga'], 0, ',', '.') }}
                </p>
            </div>

            <p class="text-green-600 font-bold">
                Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
            </p>
        </div>
        @endforeach

    </div>

    {{-- TOTAL & BUTTON --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-bold">Total Pembayaran</h2>
        <h1 class="text-3xl text-green-700 font-extrabold mt-2">
            Rp {{ number_format($total, 0, ',', '.') }}
        </h1>

        <form method="POST" action="{{ route('pelanggan.checkout.process') }}">
            @csrf
            <button class="mt-5 w-full bg-green-600 hover:bg-green-700 text-white py-3 text-xl font-semibold rounded-lg">
                Bayar Sekarang
            </button>
        </form>
    </div>

</div>

</x-app-layout>
