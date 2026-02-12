<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // Ambil semua user tanpa filter role agar admin bisa lihat semuanya
        $users = User::orderByRaw("CASE
            WHEN role = 'admin' THEN 1
            WHEN role = 'karyawan' THEN 2
            ELSE 3
            END ASC")
        ->get();
        return view('user.index', compact('users'));
    }
    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:5',
            'role'     => 'required|in:admin,karyawan,pelanggan' // Validasi role
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => $request->role, // Simpan role dari input
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id); // Ubah dari $karyawan jadi $user
        return view('user.edit', compact('user')); // Kirim variabel $user ke view
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id); // Cari berdasarkan ID

        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'role'  => 'required' // Jangan lupa validasi role
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role, // Update rolenya juga
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('user.index')->with('success', 'Data user diperbarui');
    }

    public function destroy($id)
    {
        User::destroy($id);

        return redirect()->route('user.index')->with('success', 'User dihapus');
    }
}
