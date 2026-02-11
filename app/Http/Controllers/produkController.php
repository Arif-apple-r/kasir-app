<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\produk;

class ProdukController extends Controller
{
        // Fungsi untuk menampilkan semua produk
    public function index()
    {
        $produk = Produk::all();
        return view('produk.index', compact('produk'));
    }

    // Menampilkan form tambah produk
    public function create()
    {
        return view('produk.create');
    }

    // Menyimpan data produk baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        // Upload file foto
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('produk', 'public');
        }

        // Simpan ke database
        Produk::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produk.edit', compact('produk'));
    }

    // Simpan perubahan edit
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $produk = Produk::findOrFail($id);

        // Jika ada foto baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($produk->foto && file_exists(storage_path('app/public/'.$produk->foto))) {
                unlink(storage_path('app/public/'.$produk->foto));
            }

            // Upload foto baru
            $produk->foto = $request->file('foto')->store('produk', 'public');
        }

        // Update data
        $produk->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'foto' => $produk->foto,
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diupdate!');
    }

    // Hapus produk
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        // Hapus foto jika ada
        if ($produk->foto && file_exists(storage_path('app/public/'.$produk->foto))) {
            unlink(storage_path('app/public/'.$produk->foto));
        }

        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
    }
}
