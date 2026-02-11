<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Penjualan;
use App\Models\User;
use App\Models\DetailPenjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PenjualanController extends Controller
{
    // Menampilkan halaman form transaksi

    public function index()
    {
        $penjualan = Penjualan::with('pelanggan', 'karyawan')->latest()->get();

        return view('penjualan.index', compact('penjualan'));
    }
    public function create()
    {
        $produk = Produk::all(); // produk untuk dipilih
        $pelanggan = \App\Models\User::where('role', 'pelanggan')->get();

        return view('penjualan.create', compact('produk', 'pelanggan'));
    }

    // Menyimpan transaksi penjualan
    public function store(Request $request)
    {
        // Validasi input dasar transaksi
        $request->validate([
            'produk_id.*' => 'required|exists:produk,id',
            'jumlah.*' => 'required|integer|min:1',
            'pelanggan_id' => 'nullable|exists:users,id',
        ]);

        // ====== 1. Hitung total transaksi ======

        $total = 0;
        foreach ($request->produk_id as $i => $produkId) {
            $produk = Produk::find($produkId);
            $subtotal = $produk->harga * $request->jumlah[$i];
            $total += $subtotal;
        }

        // ====== 2. Simpan ke tabel penjualan ======

        $penjualan = Penjualan::create([
            'user_id' => $request->pelanggan_id, // pelanggan
            'karyawan_id' => Auth::id(), // kasir otomatis
            'total_harga' => $total,
            'metode_pembayaran' => 'cash',
            'status_pesanan' => 'selesai',
            'tanggal_penjualan' => now(),
        ]);

        // ====== 3. Simpan detail penjualan ======

        foreach ($request->produk_id as $i => $produkId) {

            $produk = Produk::find($produkId);
            $jumlah = $request->jumlah[$i];
            $subtotal = $produk->harga * $jumlah;

            DetailPenjualan::create([
                'penjualan_id' => $penjualan->id,
                'produk_id' => $produk->id,
                'jumlah' => $jumlah,
                'harga_saat_itu' => $produk->harga,
                'subtotal' => $subtotal,
            ]);

            // ====== 4. Kurangi stok produk ======
            $produk->stok -= $jumlah;
            $produk->save();
        }

        return redirect()->route('penjualan.show', $penjualan->id)
            ->with('success', 'Transaksi berhasil dibuat!');
    }

    // Tampilkan detail transaksi
    public function show($id)
    {
        $penjualan = Penjualan::with('detail.produk', 'pelanggan', 'karyawan')->findOrFail($id);
        return view('penjualan.show', compact('penjualan'));
    }

    public function kasir()
    {
        $produk = Produk::all();
        $pelanggan = User::where('role', 'pelanggan')->get();

        return view('kasir.index', compact('produk', 'pelanggan'));
    }


}
