<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class PelangganController extends Controller
{
    public function index()
    {
        $produk = Produk::all();
        return view('pelanggan.index', compact('produk'));
    }

    public function home()
    {
        $produk = Produk::latest()->take(6)->get();
        return view('pelanggan.home.index', compact('produk'));
    }

    public function produkIndex(Request $request)
    {
        $query = Produk::query();

        // SEARCH
        if ($request->has('search') && $request->search != '') {
            $query->where('nama', 'LIKE', '%' . $request->search . '%');
        }

        $produk = $query->paginate(12);

        return view('pelanggan.produk.index', compact('produk'));
    }


    public function show($id)
    {
        $produk = Produk::findOrFail($id);

        return view('pelanggan.produk.show', compact('produk'));
    }
}
