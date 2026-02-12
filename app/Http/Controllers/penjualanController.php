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
        $penjualan = Penjualan::selesai()
            ->with('pelanggan', 'karyawan')
            ->latest()
            ->get();

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

        // ====== 1. Validasi stok & Hitung total transaksi ======

        $total = 0;
        foreach ($request->produk_id as $i => $produkId) {
            $produk = Produk::find($produkId);
            if ($produk->stok < $request->jumlah[$i]) {
                return back()->with('error', "Stok produk {$produk->nama} tidak mencukupi.");
            }
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

        $routeName = (Auth::user()->role === 'karyawan')
            ? 'kasir.penjualan.show'
            : 'penjualan.show';

        return redirect()->route($routeName, $penjualan->id)
            ->with('success', 'Transaksi berhasil dibuat!');
    }

    // Tampilkan detail transaksi
    public function show($id)
    {
        $penjualan = Penjualan::with('detail.produk', 'pelanggan', 'karyawan')->findOrFail($id);

        if (Auth::check() && Auth::user()->role === 'karyawan') {
            if ($penjualan->karyawan_id !== Auth::id()) {
                abort(403, 'Akses ditolak bro!');
            }
        }
        return view('penjualan.show', compact('penjualan'));
    }

    public function print($id)
    {
        $penjualan = Penjualan::with('detail.produk', 'pelanggan', 'karyawan')->findOrFail($id);

        if (Auth::check() && Auth::user()->role === 'karyawan') {
            if ($penjualan->karyawan_id !== Auth::id()) {
                abort(403, 'Akses ditolak bro!');
            }
        }
        return view('penjualan.print', compact('penjualan'));
    }

    public function printAll()
    {
        $penjualan = Penjualan::selesai()
            ->with('pelanggan', 'karyawan')
            ->latest()
            ->get();

        return view('penjualan.printAll', compact('penjualan'));
    }

    // Menampilkan halaman utama Kasir dengan 2 data: Produk (untuk POS) dan Pesanan Pending
    public function kasir()
    {
        $produk = Produk::where('stok', '>', 0)->get();
        $pelanggan = User::where('role', 'pelanggan')->get();

        // Ambil pesanan online yang statusnya masih pending
        $pesananPending = Penjualan::with('pelanggan')
                            ->where('status_pesanan', 'pending')
                            ->latest()
                            ->get();

        $todayTotal = Penjualan::selesai()
            ->where('karyawan_id', Auth::id())
            ->whereDate('tanggal_penjualan', today())
            ->sum('total_harga');

        $todayCount = Penjualan::selesai()
            ->where('karyawan_id', Auth::id())
            ->whereDate('tanggal_penjualan', today())
            ->count();

        $transaksiTerbaruSaya = Penjualan::selesai()
            ->with('pelanggan')
            ->where('karyawan_id', Auth::id())
            ->latest()
            ->limit(10)
            ->get();

        return view('kasir.index', compact(
            'produk',
            'pelanggan',
            'pesananPending',
            'todayTotal',
            'todayCount',
            'transaksiTerbaruSaya'
        ));
    }

    // Fungsi untuk Kasir menyetujui pesanan online
    public function konfirmasiPesanan($id)
    {
        $penjualan = Penjualan::findOrFail($id);

        $penjualan->update([
            'status_pesanan' => 'selesai',
            'karyawan_id'    => auth()->id(), // Catat siapa kasir yang proses
        ]);

        return back()->with('success', 'Pesanan online berhasil dikonfirmasi!');
    }

}
