<?php

// namespace App\Http\Controllers;

// use App\Models\Produk;
// use App\Models\Penjualan;
// use App\Models\User;
// use App\Models\DetailPenjualan;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

// class KasirController extends Controller
// {
//     public function index()
//     {
//         $produk = Produk::where('stok', '>', 0)->get();
//         $pelanggan = User::where('role', 'pelanggan')->get();

//         $pesananPending = Penjualan::with('pelanggan')
//             ->where('status_pesanan', 'pending')
//             ->latest()
//             ->get();

//         $todayTotal = Penjualan::selesai()
//             ->where('karyawan_id', Auth::id())
//             ->whereDate('tanggal_penjualan', today())
//             ->sum('total_harga');

//         $todayCount = Penjualan::selesai()
//             ->where('karyawan_id', Auth::id())
//             ->whereDate('tanggal_penjualan', today())
//             ->count();

//         $transaksiTerbaruSaya = Penjualan::selesai()
//             ->with('pelanggan')
//             ->where('karyawan_id', Auth::id())
//             ->latest()
//             ->limit(10)
//             ->get();

//         return view('kasir.index', compact(
//             'produk',
//             'pelanggan',
//             'pesananPending',
//             'todayTotal',
//             'todayCount',
//             'transaksiTerbaruSaya'
//         ));
//     }

//     public function store(Request $request)
//     {
//         $request->validate([
//             'produk_id.*' => 'required|exists:produk,id',
//             'jumlah.*' => 'required|integer|min:1',
//             'pelanggan_id' => 'nullable|exists:users,id',
//         ]);

//         $total = 0;
//         foreach ($request->produk_id as $i => $produkId) {
//             $produk = Produk::find($produkId);
//             if ($produk->stok < $request->jumlah[$i]) {
//                 return back()->with('error', "Stok produk {$produk->nama} tidak mencukupi.");
//             }
//             $subtotal = $produk->harga * $request->jumlah[$i];
//             $total += $subtotal;
//         }

//         $penjualan = Penjualan::create([
//             'user_id' => $request->pelanggan_id,
//             'karyawan_id' => Auth::id(),
//             'total_harga' => $total,
//             'metode_pembayaran' => 'cash',
//             'status_pesanan' => 'selesai',
//             'tanggal_penjualan' => now(),
//         ]);

//         foreach ($request->produk_id as $i => $produkId) {
//             $produk = Produk::find($produkId);
//             $jumlah = $request->jumlah[$i];
//             $subtotal = $produk->harga * $jumlah;

//             DetailPenjualan::create([
//                 'penjualan_id' => $penjualan->id,
//                 'produk_id' => $produk->id,
//                 'jumlah' => $jumlah,
//                 'harga_saat_itu' => $produk->harga,
//                 'subtotal' => $subtotal,
//             ]);

//             $produk->stok -= $jumlah;
//             $produk->save();
//         }

//         return redirect()->route('kasir.penjualan.show', $penjualan->id)
//             ->with('success', 'Transaksi berhasil dibuat!');
//     }

//     public function konfirmasiPesanan($id)
//     {
//         $penjualan = Penjualan::findOrFail($id);

//         $penjualan->update([
//             'status_pesanan' => 'selesai',
//             'karyawan_id'    => Auth::id(),
//         ]);

//         return back()->with('success', 'Pesanan online berhasil dikonfirmasi!');
//     }

//     public function show($id)
//     {
//         $penjualan = Penjualan::with('detail.produk', 'pelanggan', 'karyawan')->findOrFail($id);

//         if ($penjualan->karyawan_id !== Auth::id()) {
//             abort(403, 'Akses ditolak bro!');
//         }

//         return view('penjualan.show', compact('penjualan'));
//     }
// }
