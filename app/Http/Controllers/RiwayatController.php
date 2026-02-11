<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $riwayat = Penjualan::with('detail.produk')
            ->where('user_id', $userId)
            ->orderBy('id', 'DESC')
            ->get();

        return view('pelanggan.riwayat.index', compact('riwayat'));
    }

    public function show($id)
    {
        $userId = Auth::id();

        $penjualan = Penjualan::with('detail.produk')
            ->where('user_id', $userId) // keamanan: hanya boleh lihat punya sendiri
            ->findOrFail($id);

        return view('pelanggan.riwayat.show', compact('penjualan'));
    }
}
