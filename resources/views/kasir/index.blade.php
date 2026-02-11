<x-app-layout>

<div class="max-w-6xl mx-auto">

    <h1 class="text-3xl font-bold mb-6">Kasir POS</h1>

    <form action="{{ route('kasir.store') }}" method="POST">
        @csrf

        {{-- PILIH PELANGGAN --}}
        <div class="bg-white p-5 rounded-xl shadow mb-6">

            <label class="font-semibold">Pelanggan</label>

            <select name="pelanggan_id"
                    class="w-full mt-2 border p-2 rounded-lg">
                <option value="">Umum / Tidak dikenal</option>

                @foreach ($pelanggan as $plg)
                    <option value="{{ $plg->id }}">
                        {{ $plg->name }}
                    </option>
                @endforeach
            </select>

        </div>

        {{-- PRODUK --}}
        <div class="bg-white p-5 rounded-xl shadow mb-6">

            <h2 class="font-bold text-xl mb-4">Tambah Produk</h2>

            <div id="produk-list">
                @include('kasir.partials.row')
            </div>

            <button type="button"
                    onclick="addRow()"
                    class="mt-4 px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-black">
                + Tambah Produk
            </button>

        </div>

        {{-- TOTAL --}}
        <div class="bg-white p-5 rounded-xl shadow">

            <h2 class="font-semibold text-xl">Total Pembayaran: </h2>
            <h1 class="text-4xl font-bold mt-2" id="total-display">
                Rp 0
            </h1>

            <button class="mt-6 w-full p-4 bg-green-600 text-white rounded-lg
                           text-2xl font-bold hover:bg-green-700">
                BAYAR
            </button>

        </div>

    </form>
    <form method="POST" action="{{ route('logout') }}" class="mt-6">
        @csrf
        <button type="submit"
                class="block w-full text-left px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white font-semibold">
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
