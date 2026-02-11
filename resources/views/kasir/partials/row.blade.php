<div class="grid grid-cols-12 gap-4 mb-3 produk-row">

    <div class="col-span-6">
        <select name="produk_id[]" class="produk-select w-full border p-2 rounded-lg">
            <option value="">-- pilih produk --</option>
            @foreach ($produk as $p)
                <option value="{{ $p->id }}" data-harga="{{ $p->harga }}">
                    {{ $p->nama }} - Rp {{ number_format($p->harga, 0, ',', '.') }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-span-3">
        <input type="number" name="jumlah[]"
               class="jumlah-input w-full border p-2 rounded-lg"
               placeholder="Jumlah">
    </div>

    <div class="col-span-3">
        <input type="text" class="subtotal w-full border p-2 rounded-lg bg-gray-100"
               placeholder="Subtotal" readonly>
    </div>

</div>
