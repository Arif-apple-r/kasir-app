<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\User;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Hitung data summary
        $totalProduk = Produk::count();
        $totalPelanggan = User::where('role', 'pelanggan')->count();
        $totalKaryawan = User::where('role', 'karyawan')->count();
        $penjualanHariIni = Penjualan::whereDate('tanggal_penjualan', today())->sum('total_harga');

        // Penjualan terbaru
        $penjualanTerbaru = Penjualan::with('pelanggan', 'karyawan')
            ->orderBy('id', 'DESC')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalProduk',
            'totalPelanggan',
            'totalKaryawan',
            'penjualanHariIni',
            'penjualanTerbaru'
        ));
    }
}
