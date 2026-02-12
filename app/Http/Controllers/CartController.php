<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        $total = collect($cart)->sum(function ($item) {
            return $item['subtotal'];
        });

        return view('pelanggan.cart.index', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        $produk = Produk::findOrFail($request->produk_id);
        $jumlah = $request->jumlah ?? 1;

        $cart = session()->get('cart', []);

        if (isset($cart[$produk->id])) {
            $cart[$produk->id]['jumlah'] += $jumlah;
            $cart[$produk->id]['subtotal'] =
                $cart[$produk->id]['jumlah'] * $produk->harga;
        } else {
            $cart[$produk->id] = [
                'nama' => $produk->nama,
                'harga' => $produk->harga,
                'jumlah' => $jumlah,
                'foto' => $produk->foto,
                'subtotal' => $produk->harga * $jumlah,
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Produk masuk ke keranjang!');
    }

    public function update(Request $request)
    {
        $cart = session()->get('cart', []);

        $id = $request->id;
        $jumlah = $request->jumlah;

        if (isset($cart[$id])) {
            $cart[$id]['jumlah'] = $jumlah;
            $cart[$id]['subtotal'] = $jumlah * $cart[$id]['harga'];
            session()->put('cart', $cart);
        }

        return back();
    }

    public function delete(Request $request)
    {
        $cart = session()->get('cart', []);

        unset($cart[$request->id]);

        session()->put('cart', $cart);

        return back();
    }

    public function checkoutPage()
    {
        $cart = session()->get('cart', []);

        if (count($cart) == 0) {
            return redirect()->route('pelanggan.cart.index')
                ->with('error', 'Keranjang masih kosong!');
        }

        $total = collect($cart)->sum(fn($item) => $item['subtotal']);

        return view('pelanggan.checkout.index', compact('cart', 'total'));
    }

    public function checkoutProcess(Request $request)
    {
        $cart = session()->get('cart', []);

        if (count($cart) == 0) {
            return redirect()->route('pelanggan.cart.index')->with('error', 'Keranjang kosong!');
        }

        $total = collect($cart)->sum(fn($item) => $item['subtotal']);

        // Gunakan DB Transaction supaya kalau satu gagal, semua batal (opsional tapi disarankan)
        \DB::beginTransaction();
        try {
            // 1. Simpan ke tabel penjualan (Sesuaikan user_id)
            $penjualan = \App\Models\Penjualan::create([
                'total_harga'       => $total,
                'user_id'           => auth()->id(),
                'karyawan_id'       => null,
                'status_pesanan'    => 'pending',
                'metode_pembayaran' => 'cash',
                'tanggal_penjualan' => now(),
            ]);

            // 2. Simpan detail penjualan
            foreach ($cart as $id => $item) {
                $produk = \App\Models\Produk::find($id);

                // Cek stok sekali lagi sebelum buat transaksi
                if ($produk->stok < $item['jumlah']) {
                    throw new \Exception("Stok produk {$produk->nama} tidak mencukupi!");
                }

                \App\Models\DetailPenjualan::create([
                    'penjualan_id'  => $penjualan->id,
                    'produk_id'     => $id,
                    'jumlah'        => $item['jumlah'], // Sesuai kolom di model DetailPenjualan
                    'harga_saat_itu'=> $item['harga'],  // Tambahkan ini jika ada di database
                    'subtotal'      => $item['subtotal'],
                ]);

                // KURANGI STOK PRODUK
                $produk->stok -= $item['jumlah'];
                $produk->save();
            }

            \DB::commit();
            session()->forget('cart');

            return redirect()->route('pelanggan.riwayat')
                            ->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            \DB::rollback();
            return back()->with('error', 'Gagal checkout: ' . $e->getMessage());
        }
    }
}
